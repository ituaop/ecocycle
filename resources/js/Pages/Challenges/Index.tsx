import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface Challenge {
    id: string;
    title: string;
    description: string;
    emoji: string;
    type: string;
    type_label: string;
    type_emoji: string;
    category: string;
    category_label: string;
    target_value: number;
    bonus_points: number;
    badge_color: string;
    starts_at: string;
    ends_at: string;
    days_remaining: number;
    joined: boolean;
    user_challenge_id: string | null;
    current_value: number;
    completed: boolean;
    reward_claimed: boolean;
    progress_pct: number;
}

interface Props extends PageProps {
    challenges: Challenge[];
    joinedCount: number;
    completedCount: number;
    totalChallenges: number;
}

const TYPE_FILTERS = ['ALL', 'WEEKLY', 'MONTHLY', 'SPECIAL'] as const;
const TYPE_META: Record<string, { label: string; emoji: string; color: string; bg: string }> = {
    ALL:     { label: 'Todos',     emoji: '🎯', color: '#1a3a2a', bg: '#f0fdf4' },
    WEEKLY:  { label: 'Semanales', emoji: '📅', color: '#b45309', bg: '#fefce8' },
    MONTHLY: { label: 'Mensuales', emoji: '🗓️', color: '#0369a1', bg: '#eff6ff' },
    SPECIAL: { label: 'Especiales',emoji: '⚡', color: '#7c3aed', bg: '#fdf4ff' },
};

const CSS = `
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; }

.objetivo-layout { display: grid; grid-template-columns: 1fr 290px; gap: 1.25rem; align-items: start; }
@media(max-width:960px){ .objeetivos-layout { grid-template-columns: 1fr; } .objetivo-sidebar { order: -1; } }

.objetivo-hero { background: linear-gradient(135deg, #1a3a2a, #166534, #15803d); border-radius: 16px; padding: 1.75rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 1.5rem; }
@media(max-width:600px){ .objetivo-hero { flex-direction: column; text-align: center; } }
.objetivo-hero-icon { font-size: 52px; flex-shrink: 0; animation: float 3s ease infinite; }
.objetivo-hero-title { font-family: 'DM Serif Display', serif; font-size: 22px; color: #fff; margin-bottom: 4px; }
.objetivo-hero-sub { font-size: 13px; color: rgba(255,255,255,0.65); font-weight: 300; }
.objetivo-hero-stats { display: flex; gap: 1.5rem; margin-top: 12px; flex-wrap: wrap; }
.objetivo-hero-stat { text-align: center; }
.objetivo-hero-stat-val { font-size: 22px; font-weight: 700; color: #fff; }
.objetivo-hero-stat-label { font-size: 11px; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 0.4px; }

.filter-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; align-items: center; }
.filter-btn { padding: 5px 13px; border-radius: 20px; border: 1.5px solid #e0e0e0; background: #fff; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif; color: #6b7c6d; }
.filter-btn:hover { border-color: #2d6a4f; color: #2d6a4f; }
.filter-btn.on { background: #1a3a2a; color: #fff; border-color: #1a3a2a; }

.objetivo-grid { display: flex; flex-direction: column; gap: 12px; }

.objetivo-card { background: #fff; border-radius: 16px; border: 2px solid #e8ebe6; padding: 1.25rem 1.5rem; transition: all 0.2s; position: relative; overflow: hidden; }
.objetivo-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
.objetivo-card.completed { border-color: #bbf7d0; background: #f0fdf4; }
.objetivo-card.joined-active { border-color: currentColor; }

.objetivo-card-top { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 12px; }
.objetivo-card-emoji { font-size: 36px; flex-shrink: 0; }
.objetivo-card-info { flex: 1; }
.objetivo-card-title { font-size: 15px; font-weight: 700; color: #1a3a2a; margin-bottom: 4px; }
.objetivo-card-desc { font-size: 13px; color: #6b7c6d; font-weight: 300; line-height: 1.5; }
.objetivo-card-right { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0; }

.type-pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.bonus-pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; background: #fefce8; color: #a16207; }
.days-pill { font-size: 11px; color: #9ca3af; }

.objetivo-progress-wrap { margin-bottom: 10px; }
.objetivo-progress-labels { display: flex; justify-content: space-between; font-size: 11px; color: #9ca3af; margin-bottom: 4px; }
.objetivo-progress-bar { background: #f0f0ee; border-radius: 99px; height: 8px; overflow: hidden; }
.objetivo-progress-fill { height: 100%; border-radius: 99px; transition: width 0.6s ease; }

.objetivo-card-footer { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.btn-sm { display: inline-flex; align-items: center; justify-content: center; gap: 5px; height: 36px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 500; font-family: 'DM Sans', sans-serif; border: none; cursor: pointer; transition: all 0.15s; text-decoration: none; }
.btn-join { background: #1a3a2a; color: #fff; }
.btn-join:hover { background: #2d6a4f; }
.btn-claim { background: #f59e0b; color: #fff; }
.btn-claim:hover { background: #d97706; }
.btn-done { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; cursor: default; }

.completed-badge { position: absolute; top: 14px; right: 14px; background: #22c55e; color: #fff; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; }

.sidebar-box { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; padding: 1.1rem 1.25rem; }
.sidebar-box + .sidebar-box { margin-top: 1rem; }
.sidebar-title { font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 10px; }

.stat-row { display: flex; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #f9faf8; font-size: 13px; }
.stat-row:last-child { border-bottom: none; }

.tip-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px 14px; font-size: 13px; color: #15803d; line-height: 1.55; }

.empty-state { padding: 3rem 2rem; text-align: center; background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; }

@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
`;

export default function ChallengesIndex({ challenges, joinedCount, completedCount, totalChallenges }: Props) {
    const [filter, setFilter] = useState<string>('ALL');

    const filtered = challenges.filter(c => filter === 'ALL' || c.type === filter);

    const join  = (id: string)              => router.post(route('challenges.join'),  { challenge_id: id });
    const claim = (ucId: string)            => router.post(route('challenges.claim'), { user_challenge_id: ucId });

    return (
        <AppLayout header={
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <div>
                    <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 21, color: '#1a3a2a', margin: 0 }}>
                        Retos Premium
                    </h1>
                    <p style={{ fontSize: 13, color: '#6b7c6d', margin: '3px 0 0', fontWeight: 300 }}>
                        {joinedCount} activos · {completedCount} completados
                    </p>
                </div>
                <Link href={route('rewards')} style={{ display: 'flex', alignItems: 'center', gap: 6, padding: '7px 14px', borderRadius: 9, background: '#f0fdf4', color: '#2d6a4f', border: '1.5px solid #bbf7d0', fontSize: 13, fontWeight: 500, textDecoration: 'none' }}>
                     Recompensas
                </Link>
            </div>
        }>
            <Head title="Retos Premium" />
            <style>{CSS}</style>

            {/* Hero */}
            <div className="objetivo-hero">
                <span className="objetivo-hero-icon">🏆</span>
                <div style={{ flex: 1 }}>
                    <div className="objetivo-hero-title">Retos activos esta semana</div>
                    <div className="objetivo-hero-sub">Completa retos para ganar puntos bonus y subir en el ranking.</div>
                    <div className="objetivo-hero-stats">
                        <div className="objetivo-hero-stat">
                            <div className="objetivo-hero-stat-val">{totalChallenges}</div>
                            <div className="objetivo-hero-stat-label">Retos</div>
                        </div>
                        <div className="objetivo-hero-stat">
                            <div className="objetivo-hero-stat-val">{joinedCount}</div>
                            <div className="objetivo-hero-stat-label">Unidos</div>
                        </div>
                        <div className="objetivo-hero-stat">
                            <div className="objetivo-hero-stat-val">{completedCount}</div>
                            <div className="objetivo-hero-stat-label">Completados</div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="objetivo-layout">
                {/* LEFT */}
                <div>
                    <div className="filter-row">
                        {TYPE_FILTERS.map(f => {
                            const m = TYPE_META[f];
                            return (
                                <button key={f} className={`filter-btn${filter === f ? ' on' : ''}`} onClick={() => setFilter(f)}>
                                    {m.emoji} {m.label}
                                </button>
                            );
                        })}
                    </div>

                    {filtered.length === 0 ? (
                        <div className="empty-state">
                            <div style={{ fontSize: 36, marginBottom: 8 }}>🔍</div>
                            <p style={{ color: '#9ca3af', fontSize: 14, margin: 0 }}>No hay retos en este filtro.</p>
                        </div>
                    ) : (
                        <div className="objetivo-grid">
                            {filtered.map(c => {
                                const tm = TYPE_META[c.type] ?? TYPE_META.ALL;
                                return (
                                    <div
                                        key={c.id}
                                        className={`objetivo-card${c.completed ? ' completed' : c.joined ? ' joined-active' : ''}`}
                                        style={{ color: c.badge_color }}
                                    >
                                        {c.completed && <span className="completed-badge">✓</span>}

                                        <div className="objetivo-card-top">
                                            <span className="objetivo-card-emoji">{c.emoji}</span>
                                            <div className="objetivo-card-info">
                                                <div className="objetivo-card-title">{c.title}</div>
                                                <div className="objetivo-card-desc">{c.description}</div>
                                            </div>
                                            <div className="objetivo-card-right">
                                                <span className="type-pill" style={{ background: tm.bg, color: tm.color }}>
                                                    {tm.emoji} {tm.label}
                                                </span>
                                                <span className="bonus-pill">+{c.bonus_points} pts</span>
                                                <span className="days-pill">
                                                    {c.days_remaining > 0 ? `${c.days_remaining}d restantes` : 'Último día'}
                                                </span>
                                            </div>
                                        </div>

                                        {/* Barra de progreso si está unido */}
                                        {c.joined && (
                                            <div className="objetivo-progress-wrap">
                                                <div className="objetivo-progress-labels">
                                                    <span>{c.category_label} · {c.current_value}/{c.target_value}</span>
                                                    <span>{c.progress_pct}%</span>
                                                </div>
                                                <div className="objetivo-progress-bar">
                                                    <div className="objetivo-progress-fill" style={{ width: `${c.progress_pct}%`, background: c.badge_color }}/>
                                                </div>
                                            </div>
                                        )}

                                        <div className="objetivo-card-footer">
                                            {!c.joined && (
                                                <button className="btn-sm btn-join" onClick={() => join(c.id)}>
                                                    + Unirme al reto
                                                </button>
                                            )}
                                            {c.joined && !c.completed && (
                                                <span className="btn-sm" style={{ background: `${c.badge_color}12`, color: c.badge_color, border: `1px solid ${c.badge_color}30` }}>
                                                    ♻️ En progreso
                                                </span>
                                            )}
                                            {c.completed && !c.reward_claimed && c.user_challenge_id && (
                                                <button className="btn-sm btn-claim" onClick={() => claim(c.user_challenge_id!)}>
                                                    🎁 Reclamar +{c.bonus_points} pts
                                                </button>
                                            )}
                                            {c.completed && c.reward_claimed && (
                                                <span className="btn-sm btn-done">✓ Recompensa reclamada</span>
                                            )}
                                            <span style={{ fontSize: 12, color: '#9ca3af', marginLeft: 'auto' }}>
                                                Finaliza: {c.ends_at}
                                            </span>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    )}
                </div>

                {/* RIGHT sidebar */}
                <div className="objetivo-sidebar">
                    <div className="sidebar-box">
                        <div className="sidebar-title">Mis estadísticas</div>
                        {[
                            { label: 'Retos disponibles', value: totalChallenges },
                            { label: 'Unidos',             value: joinedCount },
                            { label: 'Completados',        value: completedCount },
                            { label: 'Pendientes',         value: joinedCount - completedCount },
                        ].map((s, i) => (
                            <div key={i} className="stat-row">
                                <span style={{ color: '#6b7c6d' }}>{s.label}</span>
                                <span style={{ fontWeight: 700, color: '#1a3a2a' }}>{s.value}</span>
                            </div>
                        ))}
                    </div>

                    <div className="sidebar-box" style={{ marginTop: '1rem' }}>
                        <div className="sidebar-title">¿Cómo funciona?</div>
                        <div style={{ display: 'flex', flexDirection: 'column', gap: 10 }}>
                            {[
                                { icon: '1️⃣', text: 'Únete a un reto haciendo clic en "Unirme".' },
                                { icon: '2️⃣', text: 'Recicla normalmente — el progreso se actualiza automáticamente.' },
                                { icon: '3️⃣', text: 'Al completarlo, reclama tus puntos bonus.' },
                                { icon: '🏆', text: 'Los puntos se suman a tu total y suben en el ranking.' },
                            ].map((s, i) => (
                                <div key={i} style={{ display: 'flex', gap: 10, fontSize: 13, color: '#374151' }}>
                                    <span style={{ flexShrink: 0 }}>{s.icon}</span>
                                    <span style={{ fontWeight: 300, lineHeight: 1.5 }}>{s.text}</span>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="sidebar-box" style={{ marginTop: '1rem' }}>
                        <div className="tip-box">
                            💡 El progreso de los retos de tipo <strong>Cantidad</strong> y <strong>Puntos</strong> se actualiza solo al registrar un reciclaje.
                        </div>
                    </div>

                    <div className="sidebar-box" style={{ marginTop: '1rem' }}>
                        <div className="sidebar-title">Accesos rápidos</div>
                        <div style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
                            <Link href={route('recycle.index')} style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 6, height: 38, background: '#1a3a2a', color: '#fff', borderRadius: 8, fontSize: 13, fontWeight: 500, textDecoration: 'none' }}>
                                ♻️ Registrar reciclaje
                            </Link>
                            <Link href={route('dashboard')} style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 6, height: 38, background: '#f0fdf4', color: '#2d6a4f', borderRadius: 8, fontSize: 13, fontWeight: 500, textDecoration: 'none', border: '1.5px solid #bbf7d0' }}>
                                📊 Dashboard
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}