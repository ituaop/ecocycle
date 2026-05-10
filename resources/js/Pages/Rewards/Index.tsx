import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface Reward {
    id: number;
    name: string;
    description: string;
    emoji: string;
    category: string;
    points_required: number;
    badge_color: string;
    unlocked: boolean;
    newly_unlocked: boolean;
    pts_missing: number;
}

interface Props extends PageProps {
    rewards: Reward[];
    userPoints: number;
    unlockedCount: number;
    totalRewards: number;
    nextReward: Reward | null;
    pointsToNext: number | null;
}

const CATEGORIES = ['ALL', 'BADGE', 'DISCOUNT', 'EXPERIENCE', 'DONATION'] as const;
const CAT_LABELS: Record<string, { label: string; emoji: string; color: string; bg: string }> = {
    ALL:        { label: 'Todas',        emoji: '🎁', color: '#1a3a2a', bg: '#f0fdf4' },
    BADGE:      { label: 'Insignias',    emoji: '🏅', color: '#1d4ed8', bg: '#eff6ff' },
    DISCOUNT:   { label: 'Descuentos',   emoji: '🏷️', color: '#a16207', bg: '#fefce8' },
    EXPERIENCE: { label: 'Experiencias', emoji: '✨', color: '#7e22ce', bg: '#fdf4ff' },
    DONATION:   { label: 'Donaciones',   emoji: '🌍', color: '#15803d', bg: '#f0fdf4' },
};

export default function RewardsIndex({ rewards, userPoints, unlockedCount, totalRewards, nextReward, pointsToNext }: Props) {
    const [filter,       setFilter]       = useState<string>('ALL');
    const [showLocked,   setShowLocked]   = useState(true);
    const [selected,     setSelected]     = useState<Reward | null>(null);

    const filtered = rewards.filter(r => {
        const matchCat    = filter === 'ALL' || r.category === filter;
        const matchLocked = showLocked || r.unlocked;
        return matchCat && matchLocked;
    });

    const pctComplete = Math.round((unlockedCount / Math.max(totalRewards, 1)) * 100);

    return (
        <AppLayout header={
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <div>
                    <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 22, color: '#1a3a2a', margin: 0 }}>
                        Mis recompensas
                    </h1>
                    <p style={{ fontSize: 13, color: '#6b7c6d', margin: '3px 0 0', fontWeight: 300 }}>
                        {unlockedCount} de {totalRewards} desbloqueadas · {userPoints.toLocaleString()} pts acumulados
                    </p>
                </div>
            </div>
        }>
            <Head title="Recompensas" />
            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
                *, *::before, *::after { box-sizing: border-box; }
                body { font-family: 'DM Sans', sans-serif; }

                /* Layout */
                .rwd-layout { display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem; align-items: start; }
                @media(max-width: 960px) { .rwd-layout { grid-template-columns: 1fr; } .rwd-sidebar { order: -1; } }

                /* Hero banner */
                .rwd-hero { background: linear-gradient(135deg, #1a3a2a, #2d6a4f); border-radius: 16px; padding: 1.75rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 1.5rem; }
                @media(max-width:600px){ .rwd-hero { flex-direction: column; text-align: center; gap: 1rem; } }
                .rwd-hero-icon { font-size: 56px; flex-shrink: 0; animation: float 3s ease infinite; }
                .rwd-hero-title { font-family: 'DM Serif Display', serif; font-size: 24px; color: #fff; letter-spacing: -0.5px; margin-bottom: 4px; }
                .rwd-hero-sub { font-size: 14px; color: rgba(255,255,255,0.65); margin-bottom: 12px; font-weight: 300; }
                .rwd-hero-bar-wrap { background: rgba(0,0,0,0.2); border-radius: 99px; height: 10px; overflow: hidden; width: 100%; max-width: 320px; }
                .rwd-hero-bar { height: 100%; border-radius: 99px; background: #52b788; transition: width 0.8s ease; }
                .rwd-hero-bar-labels { display: flex; justify-content: space-between; font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 5px; max-width: 320px; }

                /* Filters */
                .filter-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; align-items: center; }
                .filter-btn { padding: 5px 13px; border-radius: 20px; border: 1.5px solid #e0e0e0; background: #fff; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif; color: #6b7c6d; }
                .filter-btn:hover { border-color: #2d6a4f; color: #2d6a4f; }
                .filter-btn.on { background: #1a3a2a; color: #fff; border-color: #1a3a2a; }
                .toggle-lock { display: flex; align-items: center; gap: 6px; font-size: 12px; color: '#6b7c6d'; cursor: pointer; margin-left: auto; background: none; border: none; font-family: 'DM Sans', sans-serif; }
                .toggle-lock input { accent-color: #2d6a4f; width: 15px; height: 15px; cursor: pointer; }

                /* Grid */
                .rewards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }

                /* Card */
                .rwd-card { border-radius: 16px; border: 2px solid; padding: 1.25rem; text-align: center; cursor: pointer; transition: all 0.2s; position: relative; overflow: hidden; }
                .rwd-card.unlocked:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
                .rwd-card.locked { opacity: 0.62; cursor: default; }
                .rwd-card.locked:hover { opacity: 0.75; }
                .rwd-card.selected { box-shadow: 0 0 0 3px currentColor; }
                .rwd-card-emoji { font-size: 40px; margin-bottom: 8px; line-height: 1; }
                .rwd-card-name  { font-size: 13px; font-weight: 700; color: #1a3a2a; margin-bottom: 4px; line-height: 1.3; }
                .rwd-card-cat   { font-size: 11px; color: #9ca3af; margin-bottom: 8px; }
                .rwd-card-pts   { font-size: 12px; font-weight: 700; }
                .rwd-check-badge { position: absolute; top: 10px; right: 10px; background: #22c55e; color: #fff; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 12px; }
                .rwd-lock-badge  { position: absolute; top: 10px; right: 10px; font-size: 16px; opacity: 0.4; }
                .rwd-new-badge   { position: absolute; top: 10px; left: 10px; background: #f59e0b; color: #fff; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 20px; letter-spacing: 0.5px; text-transform: uppercase; }
                .mini-progress { background: rgba(0,0,0,0.08); border-radius: 99px; height: 4px; overflow: hidden; margin-top: 8px; }
                .mini-progress-fill { height: 100%; border-radius: 99px; }

                /* Detail panel */
                .detail-panel { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; overflow: hidden; position: sticky; top: 80px; }
                .detail-header { padding: 1.5rem; text-align: center; }
                .detail-emoji-big { font-size: 64px; line-height: 1; margin-bottom: 10px; }
                .detail-title { font-family: 'DM Serif Display', serif; font-size: 20px; color: #1a3a2a; margin-bottom: 4px; letter-spacing: -0.3px; }
                .detail-cat-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 12px; }
                .detail-desc { font-size: 14px; color: '#6b7c6d'; line-height: 1.65; font-weight: 300; }
                .detail-body { padding: 0 1.25rem 1.25rem; }
                .detail-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f9faf8; font-size: 14px; }
                .detail-row:last-child { border-bottom: none; }
                .detail-label-sm { color: '#6b7c6d'; }
                .detail-val-sm { font-weight: 600; color: #1a3a2a; }
                .pts-progress-section { padding: 1rem 1.25rem; border-top: 1px solid #f0f0ee; }
                .pts-track { background: #f0f0ee; border-radius: 99px; height: 8px; overflow: hidden; margin: 8px 0; }
                .pts-fill  { height: 100%; border-radius: 99px; transition: width 0.6s ease; }
                .btn-unlock { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; height: 46px; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: 'DM Sans', sans-serif; border: none; cursor: pointer; transition: all 0.15s; margin-top: 1rem; text-decoration: none; }
                .no-selection { padding: 3rem 1.5rem; text-align: center; }
                .empty-state { padding: 3rem 2rem; text-align: center; background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; }

                /* Next reward countdown */
                .next-reward-box { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; padding: 1.1rem 1.25rem; margin-bottom: 1.25rem; }
                .next-rwd-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 8px; }
                .next-rwd-row   { display: flex; align-items: center; gap: 10px; }
                .next-rwd-icon  { font-size: 30px; flex-shrink: 0; }
                .next-rwd-name  { font-size: 14px; font-weight: 600; color: #1a3a2a; margin-bottom: 2px; }
                .next-rwd-pts   { font-size: 12px; color: '#6b7c6d'; }
                .next-rwd-bar   { background: #f0f0ee; border-radius: 99px; height: 6px; overflow: hidden; margin-top: 10px; }
                .next-rwd-fill  { height: 100%; border-radius: 99px; transition: width 0.6s ease; }

                @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
                @keyframes popIn { 0%{transform:scale(0.8);opacity:0} 100%{transform:scale(1);opacity:1} }
                .newly { animation: popIn 0.4s cubic-bezier(0.34,1.56,0.64,1) forwards; }
            `}</style>

            {/* ── Hero banner ── */}
            <div className="rwd-hero">
                <span className="rwd-hero-icon">🎁</span>
                <div style={{ flex: 1 }}>
                    <div className="rwd-hero-title">
                        {unlockedCount === totalRewards ? '¡Colección completa! 🏆' : `${unlockedCount} recompensa${unlockedCount !== 1 ? 's' : ''} desbloqueada${unlockedCount !== 1 ? 's' : ''}`}
                    </div>
                    <div className="rwd-hero-sub">
                        {nextReward
                            ? `Faltan ${pointsToNext} pts para tu próxima recompensa: ${nextReward.name}`
                            : '¡Has desbloqueado todas las recompensas disponibles!'}
                    </div>
                    <div className="rwd-hero-bar-wrap">
                        <div className="rwd-hero-bar" style={{ width: `${pctComplete}%` }} />
                    </div>
                    <div className="rwd-hero-bar-labels">
                        <span>{unlockedCount}/{totalRewards} desbloqueadas</span>
                        <span>{pctComplete}%</span>
                    </div>
                </div>
            </div>

            <div className="rwd-layout">
                {/* ── LEFT: filters + grid ── */}
                <div>
                    {/* Filters */}
                    <div className="filter-row">
                        {CATEGORIES.map(cat => {
                            const cm = CAT_LABELS[cat];
                            return (
                                <button key={cat} className={`filter-btn${filter === cat ? ' on' : ''}`}
                                    onClick={() => setFilter(cat)}>
                                    {cm.emoji} {cm.label}
                                </button>
                            );
                        })}
                        <label className="toggle-lock">
                            <input type="checkbox" checked={showLocked} onChange={e => setShowLocked(e.target.checked)} />
                            Mostrar bloqueadas
                        </label>
                    </div>

                    <div style={{ fontSize: 12, color: '#9ca3af', marginBottom: 10 }}>
                        {filtered.filter(r => r.unlocked).length} desbloqueadas · {filtered.filter(r => !r.unlocked).length} bloqueadas
                    </div>

                    {/* Grid */}
                    {filtered.length === 0 ? (
                        <div className="empty-state">
                            <div style={{ fontSize: 40, marginBottom: 10 }}>🔍</div>
                            <p style={{ color: '#9ca3af', fontSize: 14, margin: 0 }}>No hay recompensas con este filtro.</p>
                        </div>
                    ) : (
                        <div className="rewards-grid">
                            {filtered.map(r => {
                                const cm     = CAT_LABELS[r.category] ?? CAT_LABELS.ALL;
                                const pct    = r.unlocked ? 100 : Math.min(100, Math.round(((r.points_required - r.pts_missing) / r.points_required) * 100));
                                const isSel  = selected?.id === r.id;
                                return (
                                    <div
                                        key={r.id}
                                        className={`rwd-card ${r.unlocked ? 'unlocked' : 'locked'}${isSel ? ' selected' : ''}${r.newly_unlocked ? ' newly' : ''}`}
                                        style={{
                                            borderColor:    r.unlocked ? `${r.badge_color}44` : '#e8ebe6',
                                            background:     r.unlocked ? `${r.badge_color}08` : '#fafaf9',
                                            color:          r.badge_color,
                                        }}
                                        onClick={() => r.unlocked && setSelected(isSel ? null : r)}
                                    >
                                        {r.newly_unlocked && <span className="rwd-new-badge">¡Nueva!</span>}
                                        {r.unlocked
                                            ? <span className="rwd-check-badge">✓</span>
                                            : <span className="rwd-lock-badge">🔒</span>
                                        }
                                        <div className="rwd-card-emoji">{r.emoji}</div>
                                        <div className="rwd-card-name">{r.name}</div>
                                        <div className="rwd-card-cat">{cm.emoji} {cm.label}</div>
                                        <div className="rwd-card-pts" style={{ color: r.unlocked ? r.badge_color : '#9ca3af' }}>
                                            {r.unlocked ? '✓ Desbloqueada' : r.pts_missing > 0 ? `Faltan ${r.pts_missing} pts` : '¡Lista para desbloquear!'}
                                        </div>
                                        {!r.unlocked && (
                                            <div className="mini-progress">
                                                <div className="mini-progress-fill" style={{ width: `${pct}%`, background: r.badge_color }} />
                                            </div>
                                        )}
                                    </div>
                                );
                            })}
                        </div>
                    )}
                </div>

                {/* ── RIGHT: sidebar ── */}
                <div className="rwd-sidebar">
                    {/* Next reward countdown */}
                    {nextReward && (
                        <div className="next-reward-box">
                            <div className="next-rwd-label">Próxima recompensa</div>
                            <div className="next-rwd-row">
                                <span className="next-rwd-icon">{nextReward.emoji}</span>
                                <div style={{ flex: 1 }}>
                                    <div className="next-rwd-name">{nextReward.name}</div>
                                    <div className="next-rwd-pts" style={{ color: '#6b7c6d' }}>
                                        {userPoints.toLocaleString()} / {nextReward.points_required.toLocaleString()} pts
                                    </div>
                                </div>
                            </div>
                            <div className="next-rwd-bar">
                                <div className="next-rwd-fill" style={{
                                    width:      `${Math.min(100, Math.round((userPoints / nextReward.points_required) * 100))}%`,
                                    background: nextReward.badge_color,
                                }} />
                            </div>
                            <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: 11, color: '#9ca3af', marginTop: 4 }}>
                                <span>{Math.min(100, Math.round((userPoints / nextReward.points_required) * 100))}% completado</span>
                                <span>Faltan {pointsToNext} pts</span>
                            </div>
                            <Link href={route('recycle.index')} style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 6, marginTop: 12, height: 40, background: '#1a3a2a', color: '#fff', borderRadius: 9, fontSize: 13, fontWeight: 500, textDecoration: 'none', fontFamily: "'DM Sans',sans-serif" }}>
                                ♻️ Reciclar para ganar pts
                            </Link>
                        </div>
                    )}

                    {/* Detail panel */}
                    <div className="detail-panel">
                        {selected ? (
                            <>
                                <div className="detail-header" style={{ borderBottom: '1px solid #f0f0ee', background: `${selected.badge_color}08` }}>
                                    <div className="detail-emoji-big">{selected.emoji}</div>
                                    <div className="detail-title">{selected.name}</div>
                                    {(() => {
                                        const cm = CAT_LABELS[selected.category] ?? CAT_LABELS.ALL;
                                        return (
                                            <div className="detail-cat-pill" style={{ background: cm.bg, color: cm.color }}>
                                                {cm.emoji} {cm.label}
                                            </div>
                                        );
                                    })()}
                                    <div className="detail-desc">{selected.description}</div>
                                </div>
                                <div className="detail-body">
                                    <div className="detail-row">
                                        <span className="detail-label-sm" style={{ color: '#6b7c6d' }}>Estado</span>
                                        <span className="detail-val-sm" style={{ color: '#22c55e' }}>✓ Desbloqueada</span>
                                    </div>
                                    <div className="detail-row">
                                        <span className="detail-label-sm" style={{ color: '#6b7c6d' }}>Puntos necesarios</span>
                                        <span className="detail-val-sm">{selected.points_required.toLocaleString()} pts</span>
                                    </div>
                                </div>
                                <div style={{ padding: '0 1.25rem 1.25rem' }}>
                                    <div style={{ background: '#f0fdf4', border: '1px solid #bbf7d0', borderRadius: 10, padding: '10px 14px', fontSize: 13, color: '#15803d' }}>
                                        🎉 ¡Esta recompensa está desbloqueada! Contacta con nosotros para canjearla.
                                    </div>
                                </div>
                            </>
                        ) : (
                            <div className="no-selection">
                                <div style={{ fontSize: 40, marginBottom: 10 }}>👆</div>
                                <p style={{ fontSize: 14, color: '#9ca3af', margin: 0, lineHeight: 1.6 }}>
                                    Haz clic en una<br/>recompensa desbloqueada<br/>para ver sus detalles
                                </p>
                            </div>
                        )}
                    </div>

                    {/* Stats summary */}
                    <div style={{ background: '#fff', borderRadius: 14, border: '1px solid #e8ebe6', padding: '1.1rem 1.25rem', marginTop: '1rem' }}>
                        <div style={{ fontSize: 13, fontWeight: 600, color: '#1a3a2a', marginBottom: '0.75rem' }}>Resumen</div>
                        {[
                            { label: 'Puntos acumulados', value: `${userPoints.toLocaleString()} pts`, color: '#2d6a4f' },
                            { label: 'Recompensas desbloqueadas', value: `${unlockedCount}/${totalRewards}` },
                            { label: 'Progreso total', value: `${pctComplete}%` },
                        ].map((s, i) => (
                            <div key={i} style={{ display: 'flex', justifyContent: 'space-between', padding: '7px 0', borderBottom: i < 2 ? '1px solid #f9faf8' : 'none', fontSize: 13 }}>
                                <span style={{ color: '#6b7c6d' }}>{s.label}</span>
                                <span style={{ fontWeight: 700, color: s.color ?? '#1a3a2a' }}>{s.value}</span>
                            </div>
                        ))}
                        <Link href={route('dashboard')} style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 6, marginTop: 12, height: 38, background: '#f0fdf4', color: '#2d6a4f', borderRadius: 9, fontSize: 13, fontWeight: 500, textDecoration: 'none', border: '1.5px solid #bbf7d0', fontFamily: "'DM Sans',sans-serif" }}>
                            📊 Ir al dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}