import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface DashboardStats {
    totalActions: number;
    totalPoints: number;
    level: string;
    activeCollectionPoints: number;
    recentActions: Array<{
        id: string;
        wasteItemName: string;
        collectionPointName: string;
        quantity: number;
        pointsEarned: number;
        date: string;
        category: string;
    }>;
    pointsByCategory: Array<{ category: string; points: number; count: number }>;
}

interface DashboardProps extends PageProps {
    stats: DashboardStats;
}

const LEVEL_CONFIG: Record<string, { color: string; bg: string; next: string; progress: number }> = {
    BEGINNER:     { color: '#6b7c6d', bg: '#f1f0e8', next: 'INTERMEDIATE', progress: 20 },
    INTERMEDIATE: { color: '#2d6a4f', bg: '#d8f3dc', next: 'ADVANCED',     progress: 50 },
    ADVANCED:     { color: '#1d6a8a', bg: '#dbeafe', next: 'EXPERT',       progress: 75 },
    EXPERT:       { color: '#92400e', bg: '#fef3c7', next: '—',            progress: 100 },
};

const CATEGORY_ICONS: Record<string, string> = {
    PLASTIC:    'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
    GLASS:      'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18',
    PAPER:      'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
    METAL:      'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
    ORGANIC:    'M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 7.19 7 5c-.29 2.19-1.14 3.31-2.29 4.06C3.57 9.99 3 11.09 3 12.25 3 14.47 4.8 16.3 7 16.3z',
    ELECTRONIC: 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
    OTHER:      'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
};

const CATEGORY_COLORS: Record<string, { bg: string; text: string; border: string }> = {
    PLASTIC:    { bg: '#eff6ff', text: '#1d4ed8', border: '#bfdbfe' },
    GLASS:      { bg: '#f0fdfa', text: '#0d9488', border: '#99f6e4' },
    PAPER:      { bg: '#fefce8', text: '#a16207', border: '#fde68a' },
    METAL:      { bg: '#f4f4f5', text: '#3f3f46', border: '#d4d4d8' },
    ORGANIC:    { bg: '#f0fdf4', text: '#15803d', border: '#bbf7d0' },
    ELECTRONIC: { bg: '#fdf4ff', text: '#7e22ce', border: '#e9d5ff' },
    OTHER:      { bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
};

export default function Dashboard({ auth, stats }: DashboardProps) {
    const user = auth.user;
    const level = user.level ?? 'BEGINNER';
    const lvlCfg = LEVEL_CONFIG[level] ?? LEVEL_CONFIG.BEGINNER;

    // Fallback demo data if stats not provided
    const s = stats ?? {
        totalActions: 24,
        totalPoints: user.total_points ?? 800,
        level,
        activeCollectionPoints: 12,
        recentActions: [
            { id: '1', wasteItemName: 'Botella PET', collectionPointName: 'Centro Cívico Norte', quantity: 5, pointsEarned: 25, date: '2026-04-22', category: 'PLASTIC' },
            { id: '2', wasteItemName: 'Periódico', collectionPointName: 'Mercado Central', quantity: 3, pointsEarned: 15, date: '2026-04-21', category: 'PAPER' },
            { id: '3', wasteItemName: 'Lata aluminio', collectionPointName: 'Parque Ribera', quantity: 8, pointsEarned: 40, date: '2026-04-20', category: 'METAL' },
        ],
        pointsByCategory: [
            { category: 'PLASTIC', points: 150, count: 12 },
            { category: 'PAPER',   points: 90,  count: 8  },
            { category: 'METAL',   points: 140, count: 4  },
        ],
    };

    return (
        <AuthenticatedLayout
            header={
                <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                    <div>
                        <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: '24px', color: '#1a3a2a', letterSpacing: '-0.3px', margin: 0 }}>
                            Hola, {user.name.split(' ')[0]} 👋
                        </h1>
                        <p style={{ fontSize: '14px', color: '#6b7c6d', margin: '2px 0 0', fontWeight: 300 }}>
                            Tu impacto ambiental de hoy
                        </p>
                    </div>
                    <Link href="#" style={{ display: 'flex', alignItems: 'center', gap: '7px', background: '#1a3a2a', color: '#fff', padding: '10px 18px', borderRadius: '10px', fontSize: '14px', fontWeight: 500, textDecoration: 'none', fontFamily: "'DM Sans',sans-serif" }}>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Nueva acción
                    </Link>
                </div>
            }
        >
            <Head title="Dashboard" />

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap');
                body { font-family:'DM Sans',sans-serif; }
                .dash-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem; }
                @media(max-width:900px) { .dash-grid { grid-template-columns:repeat(2,1fr); } }
                @media(max-width:500px) { .dash-grid { grid-template-columns:1fr; } }
                .stat-card { background:#fff; border-radius:14px; padding:1.25rem; border:1px solid #eaece8; }
                .stat-card-label { font-size:12px; color:#6b7c6d; font-weight:500; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.5rem; display:flex; align-items:center; gap:6px; }
                .stat-card-value { font-family:'DM Serif Display',serif; font-size:32px; color:#1a3a2a; letter-spacing:-0.5px; line-height:1; }
                .stat-card-sub { font-size:12px; color:#9ca3af; margin-top:4px; }
                .main-grid { display:grid; grid-template-columns:1fr 360px; gap:1.5rem; }
                @media(max-width:1024px) { .main-grid { grid-template-columns:1fr; } }
                .card { background:#fff; border-radius:14px; border:1px solid #eaece8; overflow:hidden; }
                .card-header { padding:1.25rem 1.5rem; border-bottom:1px solid #f0f0ee; display:flex; align-items:center; justify-content:space-between; }
                .card-title { font-size:15px; font-weight:500; color:#1a3a2a; }
                .card-link { font-size:13px; color:#2d6a4f; text-decoration:none; font-weight:500; }
                .action-row { display:flex; align-items:center; gap:12px; padding:1rem 1.5rem; border-bottom:1px solid #f9faf8; transition:background 0.1s; }
                .action-row:last-child { border-bottom:none; }
                .action-row:hover { background:#fafbf9; }
                .action-cat-icon { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
                .action-info { flex:1; min-width:0; }
                .action-name { font-size:14px; font-weight:500; color:#1c1c1c; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
                .action-meta { font-size:12px; color:#9ca3af; margin-top:2px; }
                .action-pts { font-size:14px; font-weight:500; color:#2d6a4f; flex-shrink:0; }
                .action-date { font-size:12px; color:#9ca3af; flex-shrink:0; }
                .level-card { padding:1.5rem; }
                .level-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:500; margin-bottom:1rem; }
                .level-name { font-size:22px; font-weight:500; color:#1a3a2a; margin-bottom:0.25rem; }
                .level-sub { font-size:13px; color:#6b7c6d; margin-bottom:1rem; }
                .progress-bar-wrap { background:#f0f0ee; border-radius:99px; height:8px; margin-bottom:0.5rem; overflow:hidden; }
                .progress-bar-fill { height:100%; border-radius:99px; background:var(--green-light,#52b788); transition:width 0.6s ease; }
                .progress-label { display:flex; justify-content:space-between; font-size:12px; color:#9ca3af; }
                .cat-row { display:flex; align-items:center; gap:10px; padding:0.85rem 1.5rem; border-bottom:1px solid #f9faf8; }
                .cat-row:last-child { border-bottom:none; }
                .cat-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
                .cat-name { font-size:13px; color:#374151; flex:1; }
                .cat-count { font-size:12px; color:#9ca3af; }
                .cat-pts { font-size:13px; font-weight:500; color:#2d6a4f; }
                .empty-state { padding:3rem 1.5rem; text-align:center; }
                .empty-icon { width:56px; height:56px; background:#f0f7f3; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; }
                .empty-text { font-size:14px; color:#9ca3af; }
            `}</style>

            {/* Stats row */}
            <div className="dash-grid">
                {[
                    { label: 'Puntos totales', value: s.totalPoints, sub: `+50 hoy`, icon: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', color: '#2d6a4f' },
                    { label: 'Acciones realizadas', value: s.totalActions, sub: 'reciclajes', icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', color: '#1d6a8a' },
                    { label: 'Nivel', value: level, sub: `Siguiente: ${lvlCfg.next}`, icon: 'M13 10V3L4 14h7v7l9-11h-7z', color: lvlCfg.color },
                    { label: 'Puntos de recogida', value: s.activeCollectionPoints, sub: 'activos cerca', icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', color: '#92400e' },
                ].map((s2, i) => (
                    <div className="stat-card" key={i}>
                        <div className="stat-card-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke={s2.color} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                <path d={s2.icon} />
                            </svg>
                            {s2.label}
                        </div>
                        <div className="stat-card-value" style={{ fontSize: typeof s2.value === 'string' ? '20px' : '32px' }}>{s2.value}</div>
                        <div className="stat-card-sub">{s2.sub}</div>
                    </div>
                ))}
            </div>

            <div className="main-grid">
                {/* Recent actions */}
                <div className="card">
                    <div className="card-header">
                        <span className="card-title">Últimas acciones de reciclaje</span>
                        <a href="#" className="card-link">Ver todas →</a>
                    </div>

                    {s.recentActions.length === 0 ? (
                        <div className="empty-state">
                            <div className="empty-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#52b788" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <p className="empty-text">Aún no has registrado ninguna acción.<br />¡Empieza reciclando hoy!</p>
                        </div>
                    ) : (
                        s.recentActions.map(action => {
                            const cc = CATEGORY_COLORS[action.category] ?? CATEGORY_COLORS.OTHER;
                            return (
                                <div className="action-row" key={action.id}>
                                    <div className="action-cat-icon" style={{ background: cc.bg, border: `1px solid ${cc.border}` }}>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke={cc.text} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <path d={CATEGORY_ICONS[action.category] ?? CATEGORY_ICONS.OTHER} />
                                        </svg>
                                    </div>
                                    <div className="action-info">
                                        <div className="action-name">{action.wasteItemName}</div>
                                        <div className="action-meta">{action.collectionPointName} · {action.quantity} unidades</div>
                                    </div>
                                    <div style={{ textAlign: 'right' }}>
                                        <div className="action-pts">+{action.pointsEarned} pts</div>
                                        <div className="action-date">{new Date(action.date).toLocaleDateString('es-ES', { day: '2-digit', month: 'short' })}</div>
                                    </div>
                                </div>
                            );
                        })
                    )}
                </div>

                {/* Sidebar */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                    {/* Level progress */}
                    <div className="card">
                        <div className="card-header">
                            <span className="card-title">Tu nivel</span>
                        </div>
                        <div className="level-card">
                            <div className="level-badge" style={{ background: lvlCfg.bg, color: lvlCfg.color }}>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                                {level.charAt(0) + level.slice(1).toLowerCase()}
                            </div>
                            <div className="level-name">{s.totalPoints} puntos</div>
                            <div className="level-sub">
                                {lvlCfg.next !== '—' ? `Siguiente nivel: ${lvlCfg.next}` : '¡Nivel máximo alcanzado!'}
                            </div>
                            <div className="progress-bar-wrap">
                                <div className="progress-bar-fill" style={{ width: `${lvlCfg.progress}%`, background: lvlCfg.color }} />
                            </div>
                            <div className="progress-label">
                                <span>0</span>
                                <span>{lvlCfg.progress}%</span>
                            </div>
                        </div>
                    </div>

                    {/* Points by category */}
                    <div className="card">
                        <div className="card-header">
                            <span className="card-title">Por categoría</span>
                        </div>
                        {s.pointsByCategory.length === 0 ? (
                            <div className="empty-state">
                                <p className="empty-text">Sin datos todavía</p>
                            </div>
                        ) : (
                            s.pointsByCategory.map(cat => {
                                const cc = CATEGORY_COLORS[cat.category] ?? CATEGORY_COLORS.OTHER;
                                return (
                                    <div className="cat-row" key={cat.category}>
                                        <div className="cat-dot" style={{ background: cc.text }} />
                                        <span className="cat-name">{cat.category.charAt(0) + cat.category.slice(1).toLowerCase()}</span>
                                        <span className="cat-count">{cat.count} acc.</span>
                                        <span className="cat-pts">{cat.points} pts</span>
                                    </div>
                                );
                            })
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
