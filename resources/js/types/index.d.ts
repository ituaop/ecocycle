export interface User {
    id: string;
    name: string;
    username: string;
    email: string;
    email_verified_at: string | null;
    total_points: number;
    level: string;
    created_at?: string;
}

export interface Rank {
    name: string;
    label: string;
    description: string;
    badge_color: string;
    badge_icon: string;
    min_points: number;
    max_points: number;
    order: number;
}

export interface WasteItem {
    id: string;
    name: string;
    description: string;
    category: string;
    points: number;
}

export interface CollectionPoint {
    id: string;
    name: string;
    address: string;
    latitude: number;
    longitude: number;
    status: string;
    schedule: string | null;
    accepted_categories: string[];
}

export interface RecycleAction {
    id: string;
    quantity: number;
    date: string;
    points_earned: number;
    level_up: boolean;
    level_before: string;
    level_after: string;
    waste_name: string;
    waste_category: string;
    cp_name: string;
    cp_address?: string;
}

export interface RankInfo {
    allRanks: Rank[];
    nextRank: Rank | null;
    progress: number;
    pointsToNext: number | null;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: { user: User };
};
