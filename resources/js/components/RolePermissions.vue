<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { Permission } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    permissions: Permission[];
    ticked_permissions: number[];
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
        permission.checked = props.ticked_permissions.includes(permission.id);
        groups[resource].push(permission);
    }

    // Sort keys to ensure consistent order if needed, or leave as is
    return groups;
});
</script>

<template>
    <div v-if="permissions && permissions.length > 0" class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <template v-for="(group, name) in groupedPermissions" :key="name">
            <div class="space-y-4">
                <h3 class="font-semibold text-lg text-foreground">{{ name }}</h3>
                <div class="flex flex-col space-y-3">
                    <div
                        v-for="permission in group"
                        :key="permission.id"
                        class="flex items-start space-x-2"
                    >
                        <Checkbox 
                            :id="`perm-${permission.id}`"
                            v-model="permission.checked"
                            class="mt-0.5 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground opacity-100" 
                        />
                        <Label
                            :for="`perm-${permission.id}`"
                            class="text-sm font-normal leading-none"
                        >
                            {{ permission.name }}
                        </Label>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <div v-else class="text-muted-foreground text-sm">
        No permissions assigned.
    </div>
</template>
