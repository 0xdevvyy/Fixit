<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutGrid, TicketCheck } from '@lucide/vue';

import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';

import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

import { dashboard } from '@/routes';
import tickets from '@/routes/tickets';

import type { NavItem } from '@/types';

const page = usePage();

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
        roles: ['admin', 'teacher', 'maintenance'],
    },
    {
        title: 'Tickets',
        href: tickets.index(),
        icon: TicketCheck,
        roles: ['admin', 'teacher', 'maintenance'],
    },
];

const footerNavItems: NavItem[] = [];

const filterNavItems = (items: NavItem[]) => {
    const userRole = page.props.auth.user.role;

    return items.filter((item) => {
        return !item.roles || item.roles.includes(userRole);
    });
};

const filteredMainNavItems = computed(() =>
    filterNavItems(mainNavItems),
);

const filteredFooterNavItems = computed(() =>
    filterNavItems(footerNavItems),
);
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="filteredMainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="filteredFooterNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>

    <slot />
</template>