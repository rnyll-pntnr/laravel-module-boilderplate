<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index } from '@/routes/users';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Users List',
        href: index().url,
    },
    {
        title: 'Create User',
        href: '#',
    },
];

const form = useForm({
    name: '',
    email: '',
    password: '',
});
</script>

<template>
    <Head title="Create User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="w-8/12">
                <form @submit.prevent="form.post(index().url)">
                    <div class="space-y-4">
                        <Label for="name">Name</Label>
                        <Input id="name" v-model="form.name" type="text" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="space-y-4">
                        <Label for="email">Email</Label>
                        <Input id="email" v-model="form.email" type="email" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="space-y-4">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            v-model="form.password"
                            type="password"
                        />
                        <InputError :message="form.errors.password" />
                    </div>
                    <Button type="submit" :disabled="form.processing"
                        >Create</Button
                    >
                </form>
            </div>
        </div>
    </AppLayout>
</template>
