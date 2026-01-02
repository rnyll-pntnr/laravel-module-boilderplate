<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index, update } from '@/routes/users';
import { type BreadcrumbItem, type User } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    user: User;
}>();

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
        title: 'Edit User',
        href: '#',
    },
];

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
});

const handleSubmit = (user: User) => {
    form.patch(update(user.id).url, {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Edit User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="w-8/12">
                <form @submit.prevent="handleSubmit(user)">
                    <div class="space-y-4">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            :value="form.name"
                        />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="space-y-4">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            type="email"
                            :value="form.email"
                        />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="space-y-4">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="off"
                        />
                        <InputError :message="form.errors.password" />
                    </div>
                    <Button type="submit" :disabled="form.processing"
                        >Update</Button
                    >
                </form>
            </div>
        </div>
    </AppLayout>
</template>
