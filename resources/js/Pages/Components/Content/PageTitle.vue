<template>
    <div class="mt-8 mb-8 text-2xl font-extrabold">
        <span v-if="title">{{ title }}</span>
        <span v-else><slot></slot></span>
    </div>
</template>
<script>
export default {
    name: "Content_PageTitle",

    props: {
        title: {
            type: String,
            default: "",
        },
    },
};
</script>
