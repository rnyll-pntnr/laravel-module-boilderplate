<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import RolePermissions from '@/components/RolePermissions.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index, update } from '@/routes/roles';
import { type BreadcrumbItem, Permission } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    role: any;
    permissions: Permission[];
    ticked_permissions: number[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Roles List',
        href: index().url,
    },
    {
        title: 'Update Role',
        href: '#',
    },
];

const form = useForm({
    name: props.role.name,
});

const permissionForm = useForm({
    permissions: props.ticked_permissions,
});

// Compute selected permissions from the permissions array
const selectedPermissions = computed(() => {
    return props.permissions
        .filter((p: Permission) => (p as any).checked)
        .map((p: Permission) => p.id);
});

const savePermissions = () => {
    permissionForm.permissions = selectedPermissions.value;
    permissionForm.patch(update(props.role.id).url, {
        preserveScroll: true,
        onSuccess: () => {
            // Success message is handled by the backend
        },
    });
};
</script>

<template>
    <Head title="Update Role" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="w-8/12">
                <form @submit.prevent="form.patch(update(props.role.id).url)">
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
                    <Button type="submit" :disabled="form.processing"
                        >Update</Button
                    >
                </form>
            </div>
        </div>

        <div class="p-4">
            <div class="space-y-4">
                <h2 class="text-xl font-semibold">Permissions</h2>
                <RolePermissions
                    :permissions="props.permissions"
                    :ticked_permissions="props.ticked_permissions"
                />
                <Button
                    @click="savePermissions"
                    :disabled="permissionForm.processing"
                >
                    Save Permissions
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
