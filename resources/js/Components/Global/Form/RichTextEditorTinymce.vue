<template>
    <div>
        <div class="form-group">
            <editor class="bg-white w-full border rounded" api-key="0a2bcnq4iqkdr8636z53igeaw5x1bhb000ouo3nmc0lworef"
                v-if="mode === modes[0]" v-model="localValue" v-bind="$attrs" :placeholder="placeholder" :init="config"
                @input="$emit('input', $event)" />

            <div v-else-if="mode === modes[1]" class="w-full">
                <div class="ql-container ql-snow">
                    <div class="ql-editor">
                        <span v-html="localValue"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";

const MODES = ["edit", "show"];

export default {
    components: {
        Editor,
    },
    props: {
        label: String,
        placeholder: String,
        modelValue: String,
        mode: {
            type: String,
            validator(val) {
                return MODES.includes(val);
            },
            default: MODES[0],
        },
        noImages: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        var media_plugins = this.noImages ? "" : "media";
        var images_plugins = this.noImages ? "" : "image";
        var images_toolbars = this.noImages ? "" : "image";

        return {
            modes: MODES,
            config: {
                forced_root_block: 'div',
                height: 500,
                width: "100%",
                content_style: "body {font-size: 14px;}",
                fontsize_formats:
                    "8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 39px 34px 38px 42px 48px",
                font_formats:
                    "`'Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats'`",
                plugins: [
                    `fullpage`,
                    `advlist autolink lists link charmap print preview anchor ${images_plugins}`,
                    `searchreplace visualblocks code fullscreen`,
                    `insertdatetime table code help wordcount ${media_plugins}`,
                ],
                toolbar: [
                    `formatselect fontsizeselect | \
          bold italic underline strikethrough forecolor backcolor link | \
          ${images_toolbars} fullscreen | \
          alignleft aligncenter alignright alignjustify`,
                    `table tabledelete | \
          tableprops tablerowprops tablecellprops | \
          tableinsertrowbefore tableinsertrowafter tabledeleterow | \
          tableinsertcolbefore tableinsertcolafter tabledeletecol`,
                ],
                file_picker_types: "image",
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement("input");
                    input.setAttribute("type", "file");
                    input.setAttribute("accept", "image/*");

                    input.onchange = function () {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function () {
                            var id = "blobid" + new Date().getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(",")[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },
            },
            localValue: this.modelValue,
        };
    },
    watch: {
        modelValue(val) {
            this.localValue = val;
        },
        localValue(val) {
            this.$emit("update:modelValue", val);
        },
    },
};
</script>
