<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { Permission } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    permissions: Permission[];
    userPermissions: number[];
}>();

const groupedPermissions = computed(() => {
    const groups: Record<string, Permission[]> = {};

    if (!props.permissions) return groups;

    for (const permission of props.permissions) {
        const parts = permission.name.split(' ');
        // Get the resource name (index 1), e.g., "Create Users" -> "Users"
        const resource = parts[1] || 'Other';

        if (!groups[resource]) {
            groups[resource] = [];
        }
        permission.checked = props.userPermissions.includes(permission.id);
        groups[resource].push(permission);
    }

    return groups;
});
</script>

<template>
    <div
        v-if="permissions && permissions.length > 0"
        class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
    >
        <template v-for="(group, name) in groupedPermissions" :key="name">
            <div class="space-y-4">
                <h3 class="border-b pb-2 text-lg font-semibold text-foreground">
                    {{ name }}
                </h3>
                <div class="flex flex-col space-y-3">
                    <div
                        v-for="permission in group"
                        :key="permission.id"
                        class="group flex cursor-pointer items-start space-x-3 rounded-lg border border-border bg-card p-3 shadow-sm transition-all duration-200 hover:border-accent-foreground/20 hover:bg-accent hover:shadow-md"
                    >
                        <Checkbox
                            :id="`user-perm-${permission.id}`"
                            v-model="permission.checked"
                            class="mt-0.5 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                        />
                        <Label
                            :for="`user-perm-${permission.id}`"
                            class="flex-1 cursor-pointer text-sm leading-none font-normal transition-colors group-hover:text-accent-foreground"
                        >
                            {{ permission.name }}
                        </Label>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <div
        v-else
        class="rounded-lg border border-dashed p-4 text-center text-sm text-muted-foreground"
    >
        No permissions available.
    </div>
</template>
