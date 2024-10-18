<template>
    <Head>
        <title>{{ $page.props.title }}</title>
        <meta name="description" content="Velzon" />
        <meta property="og:site_name" content="Velzon" />
        <meta property="og:title" :content="$page.props.title" />
        <meta property="og:description" content="Velzon" />
        <meta property="og:image" content="/images/favicon.png" />
        <meta property="og:image:secure_url" content="/images/favicon.png" />
        <meta property="og:type" content="website" />
        <meta property="og:image:width" content="300" />
        <meta property="og:image:height" content="300" />
    </Head>
</template>

<script>
import { Head } from "@inertiajs/vue3";

export default {
    components: {
        Head,
    },
};
</script>
