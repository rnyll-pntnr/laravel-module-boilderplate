<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index, store } from '@/routes/permissions';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Permissions List',
        href: index().url,
    },
    {
        title: 'Create Permission',
        href: '#',
    },
];

const form = useForm({
    name: '',
});
</script>

<template>
    <Head title="Create Permission" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="w-8/12">
                <form @submit.prevent="form.post(store().url)">
                    <div class="space-y-4">
                        <Label for="name">Name</Label>
                        <Input id="name" v-model="form.name" type="text" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <Button type="submit" :disabled="form.processing"
                        >Create</Button
                    >
                </form>
            </div>
        </div>
    </AppLayout>
</template>
