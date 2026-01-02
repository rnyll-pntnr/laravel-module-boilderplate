<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index as apiIndex } from '@/routes/api/users/index';
import { create, destroy, edit, index } from '@/routes/users';
import { User, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { MoreVerticalIcon, PencilIcon, Trash2Icon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Users List',
        href: index().url,
    },
];

const columns = [
    { data: 'name', name: 'name', title: 'Name', className: 'text-center' },
    { data: 'email', name: 'email', title: 'Email', className: 'text-center' },
    {
        data: (rowData: User) => {
            return dayjs(rowData.created_at).format('YYYY-MM-DD');
        },
        name: 'created_at',
        title: 'Date Time Created',
        className: 'text-center',
    },
    {
        data: null,
        render: '#actions',
        title: '',
        orderable: false,
        searchable: false,
    },
];
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="space-y-4">
                <Link :href="create().url">
                    <Button variant="default">Create User</Button>
                </Link>
            </div>
            <DataTable
                :columns="columns"
                class="display max-w-full text-center"
                :options="{
                    ajax: apiIndex().url,
                    serverSide: true,
                    processing: true,
                    searching: true,
                    lengthMenu: [10, 20, 50, 100],
                    pageLength: 10,
                }"
            >
                <template #actions="{ rowData }">
                    <div class="flex justify-center">
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" class="h-8 w-8 p-0">
                                    <span class="sr-only">Open menu</span>
                                    <MoreVerticalIcon class="h-4 w-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuItem>
                                    <Link
                                        :href="edit(rowData.id)"
                                        class="flex w-full items-center"
                                    >
                                        <PencilIcon class="mr-2 h-4 w-4" /> Edit
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem variant="destructive">
                                    <Link
                                        :href="destroy(rowData.id)"
                                        class="flex w-full items-center"
                                    >
                                        <Trash2Icon class="mr-2 h-4 w-4" />
                                        Delete
                                    </Link>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </template>
            </DataTable>
        </div>
    </AppLayout>
</template>
