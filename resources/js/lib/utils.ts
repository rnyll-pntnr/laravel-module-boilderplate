import { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function urlIsActive(
    urlToCheck: NonNullable<InertiaLinkProps['href']>,
    currentUrl: string,
    exact: boolean = false
) {
    const activeUrl = toUrl(urlToCheck);

    if (activeUrl === '/' || exact) {
        return currentUrl === activeUrl;
    }

    return (
        currentUrl === activeUrl ||
        currentUrl.startsWith(`${activeUrl}/`) ||
        currentUrl.startsWith(`${activeUrl}?`)
    );
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}
