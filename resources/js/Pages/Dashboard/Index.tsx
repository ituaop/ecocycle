import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps, RecycleAction, RankInfo, Rank } from '@/types';

const CAT_META: Record<string, { color: string; bg: string; label: string; emoji: string }> = {
    PLASTIC:    { color: '#1d4ed8', bg: '#eff6ff', label: 'Plástico',    emoji: '🧴' },
    GLASS:      { color: '#0d9488', bg: '#f0fdfa', label: 'Vidrio',      emoji: '🍶' },
    PAPER:      { color: '#a16207', bg: '#fefce8', label: 'Papel',       emoji: '📄' },
    METAL:      { color: '#3f3f46', bg: '#f4f4f5', label: 'Metal',       emoji: '🥫' },
    ORGANIC:    { color: '#15803d', bg: '#f0fdf4', label: 'Orgánico',    emoji: '🌿' },
    ELECTRONIC: { color: '#7e22ce', bg: '#fdf4ff', label: 'Electrónico', emoji: '📱' },
    OTHER:      { color: '#c2410c', bg: '#fff7ed', label: 'Otro',        emoji: '♻️' },
};

interface Props extends PageProps {
    stats: { total_actions: number; total_points: number; total_units: number; level: string };
    recentActions: RecycleAction[];
    byCategory: { category: string; actions: number; points: number; units: number }[];
    weekActivity: { date: string; points: number; actions: number }[];
    rankInfo: RankInfo;
}

export default function Dashboard({ auth, stats, recentActions, byCategory, weekActivity, rankInfo }: Props) {
    const user      = auth.user;
    const { allRanks, nextRank, progress, pointsToNext } = rankInfo;
    const currentRank = allRanks.find(r => r.name === (user.level ?? 'BEGINNER'));
    const maxWeekPts  = Math.max(...weekActivity.map(d => d.points), 1);

    return (
        <AppLayout header={
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <div>
                    <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 22, color: '#1a3a2a', margin: 0 }}>
                        Hola, {user.name.split(' ')[0]} 👋
                    </h1>
                    <p style={{ fontSize: 13, color: '#6b7c6d', margin: '3px 0 0', fontWeight: 300 }}>Tu impacto medioambiental de hoy</p>
                </div>
                <Link href={route('recycle.index')} style={{ display: 'flex', alignItems: 'center', gap: 7, background: '#1a3a2a', color: '#fff', padding: '9px 18px', borderRadius: 10, fontSize: 14, fontWeight: 500, textDecoration: 'none', fontFamily: "'DM Sans',sans-serif" }}>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Reciclar ahora
                </Link>
            </div>
        }>
            <Head title="Dashboard"/>
            <style>{`
                .dash-grid4 { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.25rem; }
                @media(max-width:900px){ .dash-grid4 { grid-template-columns:repeat(2,1fr); } }
                @media(max-width:500px){ .dash-grid4 { grid-template-columns:1fr; } }
                .dash-grid2 { display:grid; grid-template-columns:1fr 340px; gap:1.25rem; }
                @media(max-width:1024px){ .dash-grid2 { grid-template-columns:1fr; } }
                .card { background:#fff; border-radius:14px; border:1px solid #e8ebe6; }
                .card-hd { padding:1rem 1.25rem; border-bottom:1px solid #f0f0ee; display:flex; align-items:center; justify-content:space-between; }
                .card-title { font-size:14px; font-weight:600; color:#1a3a2a; }
                .scard { background:#fff; border-radius:14px; border:1px solid #e8ebe6; padding:1.1rem 1.25rem; }
                .scard-label { font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; display:flex; align-items:center; gap:5px; }
                .scard-val { font-family:'DM Serif Display',serif; font-size:30px; color:#1a3a2a; line-height:1; letter-spacing:-0.5px; }
                .scard-sub { font-size:12px; color:#9ca3af; margin-top:3px; }
                .action-row { display:flex; align-items:center; gap:10px; padding:0.8rem 1.25rem; border-bottom:1px solid #f9faf8; transition:background 0.1s; }
                .action-row:last-child { border-bottom:none; }
                .action-row:hover { background:#fafbf9; }
                .cat-dot { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
                .badge { display:inline-flex; align-items:center; gap:4px; padding:2px 9px; border-radius:20px; font-size:11px; font-weight:600; }
                .bar-row { display:flex; align-items:center; gap:8px; padding:0.5rem 1.25rem; }
                .bar-track { flex:1; background:#f0f0ee; border-radius:99px; height:6px; overflow:hidden; }
                .bar-fill { height:100%; border-radius:99px; transition:width 0.5s ease; }
            `}</style>

            {/* 4 stat cards */}
            <div className="dash-grid4">
                {[
                    { label: 'Puntos totales',  value: (stats.total_points).toLocaleString(), sub: 'pts acumulados',   icon: '⭐' },
                    { label: 'Reciclajes',       value: stats.total_actions,                   sub: 'acciones totales', icon: '♻️' },
                    { label: 'Unidades',         value: (stats.total_units).toLocaleString(),  sub: 'items reciclados', icon: '📦' },
                    { label: 'Rango actual',     value: currentRank?.badge_icon + ' ' + (currentRank?.label ?? stats.level), sub: nextRank ? `Siguiente: ${nextRank.label}` : '¡Rango máximo!', icon: '' },
                ].map((s, i) => (
                    <div key={i} className="scard">
                        <div className="scard-label">{s.icon} {s.label}</div>
                        <div className="scard-val" style={{ fontSize: i === 3 ? 18 : 30, marginTop: i === 3 ? 6 : 0 }}>{s.value}</div>
                        <div className="scard-sub">{s.sub}</div>
                    </div>
                ))}
            </div>

            <div className="dash-grid2">
                {/* Left: recent actions */}
                <div className="card">
                    <div className="card-hd">
                        <span className="card-title">Últimos reciclajes</span>
                        <Link href={route('profile.show')} style={{ fontSize: 12, color: '#2d6a4f', textDecoration: 'none', fontWeight: 500 }}>Ver historial →</Link>
                    </div>
                    {recentActions.length === 0 ? (
                        <div style={{ padding: '3rem 1.5rem', textAlign: 'center' }}>
                            <div style={{ fontSize: 40, marginBottom: 12 }}>🌱</div>
                            <p style={{ fontSize: 14, color: '#9ca3af', margin: 0 }}>
                                Aún no has reciclado.<br/>
                                <Link href={route('recycle.index')} style={{ color: '#2d6a4f', fontWeight: 500 }}>¡Empieza ahora!</Link>
                            </p>
                        </div>
                    ) : recentActions.map(a => {
                        const cm = CAT_META[a.waste_category] ?? CAT_META.OTHER;
                        return (
                            <div key={a.id} className="action-row">
                                <div className="cat-dot" style={{ background: cm.bg }}>{cm.emoji}</div>
                                <div style={{ flex: 1, minWidth: 0 }}>
                                    <div style={{ fontSize: 14, fontWeight: 500, color: '#1a3a2a', overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{a.waste_name}</div>
                                    <div style={{ fontSize: 12, color: '#9ca3af', marginTop: 1 }}>{a.cp_name} · {a.quantity} uds.</div>
                                </div>
                                <div style={{ textAlign: 'right', flexShrink: 0 }}>
                                    <div style={{ fontSize: 13, fontWeight: 600, color: '#2d6a4f' }}>+{a.points_earned} pts</div>
                                    {a.level_up && <span className="badge" style={{ background: '#fdf4ff', color: '#7e22ce', marginTop: 2 }}>🏆 Subida</span>}
                                    <div style={{ fontSize: 11, color: '#9ca3af' }}>{new Date(a.date).toLocaleDateString('es-ES', { day:'2-digit', month:'short' })}</div>
                                </div>
                            </div>
                        );
                    })}
                </div>

                {/* Right sidebar */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1.25rem' }}>
                    {/* Rank progress */}
                    <div className="card" style={{ padding: '1.25rem' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: 10, marginBottom: '1rem' }}>
                            <span style={{ fontSize: 32 }}>{currentRank?.badge_icon}</span>
                            <div>
                                <div style={{ fontSize: 16, fontWeight: 600, color: '#1a3a2a' }}>{currentRank?.label}</div>
                                <div style={{ fontSize: 12, color: '#6b7c6d', lineHeight: 1.4 }}>{currentRank?.description}</div>
                            </div>
                        </div>
                        <div style={{ background: '#f0f0ee', borderRadius: 99, height: 8, marginBottom: 6, overflow: 'hidden' }}>
                            <div style={{ width: `${progress}%`, height: '100%', background: currentRank?.badge_color ?? '#52b788', borderRadius: 99, transition: 'width 0.6s ease' }}/>
                        </div>
                        <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: 12, color: '#9ca3af' }}>
                            <span>{stats.total_points} pts</span>
                            {nextRank ? <span>Faltan {pointsToNext} pts → {nextRank.label}</span> : <span>¡Rango máximo alcanzado! 🏆</span>}
                        </div>

                        {/* All ranks */}
                        <div style={{ marginTop: '1.25rem', display: 'flex', flexDirection: 'column', gap: 6 }}>
                            {allRanks.map((r: Rank) => (
                                <div key={r.name} style={{ display: 'flex', alignItems: 'center', gap: 8, padding: '6px 10px', borderRadius: 8, background: r.name === user.level ? `${r.badge_color}14` : 'transparent', border: r.name === user.level ? `1px solid ${r.badge_color}33` : '1px solid transparent' }}>
                                    <span style={{ fontSize: 18 }}>{r.badge_icon}</span>
                                    <div style={{ flex: 1 }}>
                                        <div style={{ fontSize: 13, fontWeight: r.name === user.level ? 600 : 400, color: r.name === user.level ? r.badge_color : '#6b7c6d' }}>{r.label}</div>
                                        <div style={{ fontSize: 11, color: '#9ca3af' }}>{r.min_points}+ pts</div>
                                    </div>
                                    {r.name === user.level && <span style={{ fontSize: 10, fontWeight: 600, color: r.badge_color, background: `${r.badge_color}18`, padding: '2px 7px', borderRadius: 10 }}>Actual</span>}
                                    {stats.total_points >= r.min_points && r.name !== user.level && <span style={{ fontSize: 16 }}>✓</span>}
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* By category */}
                    {byCategory.length > 0 && (
                        <div className="card">
                            <div className="card-hd"><span className="card-title">Por categoría</span></div>
                            {byCategory.map(c => {
                                const cm = CAT_META[c.category] ?? CAT_META.OTHER;
                                const pct = Math.round((c.points / (stats.total_points || 1)) * 100);
                                return (
                                    <div key={c.category} className="bar-row">
                                        <span style={{ fontSize: 16 }}>{cm.emoji}</span>
                                        <div style={{ width: 70, fontSize: 12, color: '#374151', fontWeight: 500 }}>{cm.label}</div>
                                        <div className="bar-track">
                                            <div className="bar-fill" style={{ width: `${pct}%`, background: cm.color }}/>
                                        </div>
                                        <span style={{ fontSize: 12, color: '#6b7c6d', width: 55, textAlign: 'right' }}>{c.points} pts</span>
                                    </div>
                                );
                            })}
                        </div>
                    )}

                    {/* Week activity */}
                    {weekActivity.length > 0 && (
                        <div className="card" style={{ padding: '1.1rem 1.25rem' }}>
                            <div style={{ fontSize: 13, fontWeight: 600, color: '#1a3a2a', marginBottom: '0.75rem' }}>Esta semana</div>
                            <div style={{ display: 'flex', alignItems: 'flex-end', gap: 6, height: 60 }}>
                                {weekActivity.map(d => (
                                    <div key={d.date} style={{ flex: 1, display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 4 }}>
                                        <div title={`${d.points} pts`} style={{ width: '100%', background: '#52b788', borderRadius: '3px 3px 0 0', height: `${Math.round((d.points / maxWeekPts) * 52)}px`, minHeight: 4 }}/>
                                        <span style={{ fontSize: 10, color: '#9ca3af' }}>{new Date(d.date).toLocaleDateString('es-ES', { weekday: 'narrow' })}</span>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
