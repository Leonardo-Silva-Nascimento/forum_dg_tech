<template>
	<DataTable :comments="comments"  />
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import DataTable from "../../Components/Tables/table.vue";
import { defineProps } from "vue";

defineProps({
	comments: Object,
});
</script>

<style></style>