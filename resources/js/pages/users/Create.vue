<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Checkbox } from '@/components/ui/checkbox';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index } from '@/routes/users';
import { type BreadcrumbItem, type Permission, type Role } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    roles: Role[];
    permissions: Permission[];
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
        title: 'Create User',
        href: '#',
    },
];

const form = useForm({
    name: '',
    email: '',
    password: '',
    roles: [] as number[],
    permissions: [] as number[],
});

const toggleRole = (roleId: number) => {
    const index = form.roles.indexOf(roleId);
    if (index > -1) {
        form.roles.splice(index, 1);
    } else {
        form.roles.push(roleId);
    }
};

const togglePermission = (permissionId: number) => {
    const index = form.permissions.indexOf(permissionId);
    if (index > -1) {
        form.permissions.splice(index, 1);
    } else {
        form.permissions.push(permissionId);
    }
};

const handleSubmit = () => {
    form.post(index().url);
};
</script>

<template>
    <Head title="Create User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="w-full max-w-4xl">
                <form @submit.prevent="handleSubmit">
                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div class="space-y-4 rounded-lg border bg-card p-6">
                            <h2 class="mb-4 text-xl font-semibold">
                                Basic Information
                            </h2>

                            <div class="space-y-2">
                                <Label for="name">Name</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div class="space-y-2">
                                <Label for="email">Email</Label>
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                />
                                <InputError :message="form.errors.email" />
                            </div>

                            <div class="space-y-2">
                                <Label for="password">Password</Label>
                                <Input
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                />
                                <InputError :message="form.errors.password" />
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="space-y-4 rounded-lg border bg-card p-6">
                            <h2 class="mb-4 text-xl font-semibold">
                                Assign Roles
                            </h2>
                            <div
                                class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3"
                            >
                                <div
                                    v-for="role in roles"
                                    :key="role.id"
                                    class="group flex cursor-pointer items-center space-x-3 rounded-lg border border-border bg-background p-3 shadow-sm transition-all duration-200 hover:border-accent-foreground/20 hover:bg-accent hover:shadow-md"
                                    @click="toggleRole(role.id)"
                                >
                                    <Checkbox
                                        :id="`role-${role.id}`"
                                        :checked="form.roles.includes(role.id)"
                                        class="pointer-events-none"
                                    />
                                    <Label
                                        :for="`role-${role.id}`"
                                        class="flex-1 cursor-pointer text-sm font-medium transition-colors group-hover:text-accent-foreground"
                                    >
                                        {{ role.name }}
                                    </Label>
                                </div>
                            </div>
                            <InputError :message="form.errors.roles" />
                        </div>

                        <!-- Permission Customization (Optional) -->
                        <div class="space-y-4 rounded-lg border bg-card p-6">
                            <div class="space-y-2">
                                <h2 class="text-xl font-semibold">
                                    Custom Permissions (Optional)
                                </h2>
                                <p class="text-sm text-muted-foreground">
                                    Grant additional permissions beyond the
                                    assigned roles.
                                </p>
                            </div>
                            <div
                                class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
                            >
                                <div
                                    v-for="permission in permissions"
                                    :key="permission.id"
                                    class="group flex cursor-pointer items-center space-x-3 rounded-lg border border-border bg-background p-3 shadow-sm transition-all duration-200 hover:border-accent-foreground/20 hover:bg-accent hover:shadow-md"
                                    @click="togglePermission(permission.id)"
                                >
                                    <Checkbox
                                        :id="`perm-${permission.id}`"
                                        :checked="
                                            form.permissions.includes(
                                                permission.id,
                                            )
                                        "
                                        class="pointer-events-none"
                                    />
                                    <Label
                                        :for="`perm-${permission.id}`"
                                        class="flex-1 cursor-pointer text-sm font-normal transition-colors group-hover:text-accent-foreground"
                                    >
                                        {{ permission.name }}
                                    </Label>
                                </div>
                            </div>
                            <InputError :message="form.errors.permissions" />
                        </div>

                        <Button type="submit" :disabled="form.processing">
                            Create User
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
