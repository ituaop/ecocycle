import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface RecycleResult {
    points_earned: number;
    total_points:  number;
    level_before:  string;
    level_after:   string;
    level_up:      boolean;
    waste_name:    string;
    quantity:      number;
}

interface Rank {
    name:        string;
    label:       string;
    description: string;
    badge_color: string;
    badge_icon:  string;
    min_points:  number;
    max_points:  number;
    order:       number;
}

interface Props extends PageProps {
    result:       RecycleResult;
    user:         { name: string; total_points: number; level: string };
    allRanks:     Rank[];
    nextRank:     Rank | null;
    progress:     number;
    pointsToNext: number | null;
}

export default function RecycleResult({ auth, result, allRanks, nextRank, progress, pointsToNext }: Props) {
    const user        = auth.user;
    const currentRank = allRanks.find(r => r.name === user.level);
    const levelUpRank = result.level_up ? allRanks.find(r => r.name === result.level_after) : null;

    return (
        <AppLayout>
            <Head title="¡Reciclaje registrado!" />

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');

                .result-wrap { max-width: 520px; margin: 0 auto; }

                /* Level-up banner */
                .levelup-banner {
                    background: linear-gradient(135deg, #7e22ce, #a855f7);
                    border-radius: 16px 16px 0 0;
                    padding: 1.25rem 1.5rem;
                    display: flex;
                    align-items: center;
                    gap: 14px;
                    margin-bottom: 0;
                }
                .levelup-icon  { font-size: 42px; flex-shrink: 0; animation: float 2s ease infinite; }
                .levelup-title { font-size: 17px; font-weight: 700; color: #fff; }
                .levelup-sub   { font-size: 13px; color: rgba(255,255,255,0.85); margin-top: 3px; }
                .levelup-desc  { font-size: 12px; color: rgba(255,255,255,0.65); margin-top: 3px; }

                /* Main result card */
                .result-card {
                    background: #fff;
                    border: 1px solid #e8ebe6;
                    overflow: hidden;
                    margin-bottom: 1.25rem;
                }
                .result-card.rounded { border-radius: 16px; }
                .result-card.rounded-bottom { border-radius: 0 0 16px 16px; }

                /* Hero */
                .result-hero {
                    background: linear-gradient(135deg, #1a3a2a 0%, #2d6a4f 100%);
                    padding: 2.5rem 2rem;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                }
                .result-hero::before {
                    content: '';
                    position: absolute;
                    inset: 0;
                    background: radial-gradient(ellipse at 70% 30%, rgba(82,183,136,0.18) 0%, transparent 60%);
                }
                .hero-label { font-size: 18px; position: relative; margin-bottom: 10px; }
                .hero-pts   {
                    font-family: 'DM Serif Display', serif;
                    font-size: 72px;
                    color: #52b788;
                    line-height: 1;
                    letter-spacing: -3px;
                    position: relative;
                    animation: popIn 0.5s cubic-bezier(0.34,1.56,0.64,1) forwards;
                }
                .hero-pts-lbl { font-size: 16px; color: rgba(255,255,255,0.65); position: relative; margin-top: 4px; }
                .hero-detail  { font-size: 13px; color: rgba(255,255,255,0.45); position: relative; margin-top: 8px; }

                /* Detail rows */
                .detail-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 13px 1.5rem;
                    border-bottom: 1px solid #f9faf8;
                    font-size: 14px;
                }
                .detail-row:last-of-type { border-bottom: none; }
                .detail-label { color: #6b7c6d; }
                .detail-value { font-weight: 600; color: #1a3a2a; }

                /* Progress section */
                .progress-section { padding: 1.1rem 1.5rem; border-top: 1px solid #f0f0ee; }
                .progress-labels  { display: flex; justify-content: space-between; font-size: 12px; color: #9ca3af; margin-bottom: 6px; }
                .progress-track   { background: #f0f0ee; border-radius: 99px; height: 10px; overflow: hidden; }
                .progress-fill    { height: 100%; border-radius: 99px; transition: width 0.8s ease; }
                .progress-pct     { font-size: 11px; color: #9ca3af; text-align: right; margin-top: 4px; }

                /* Ranks list */
                .ranks-card {
                    background: #fff;
                    border-radius: 14px;
                    border: 1px solid #e8ebe6;
                    padding: 1.1rem 1.25rem;
                    margin-bottom: 1.25rem;
                }
                .ranks-title { font-size: 13px; font-weight: 600; color: '#1a3a2a'; margin-bottom: 0.75rem; }
                .rank-row {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 7px 10px;
                    border-radius: 9px;
                    margin-bottom: 5px;
                    border: 1.5px solid transparent;
                    transition: all 0.15s;
                }
                .rank-row:last-child { margin-bottom: 0; }
                .rank-icon-big { font-size: 24px; flex-shrink: 0; }
                .rank-label    { font-size: 13px; flex: 1; }
                .rank-pts-lbl  { font-size: 11px; color: #9ca3af; }
                .rank-badge    { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; }
                .rank-check    { font-size: 15px; color: '#2d6a4f'; }
                .rank-lock     { font-size: 13px; opacity: 0.5; }

                /* Action buttons */
                .action-btns { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
                .btn-action  {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 7px;
                    height: 50px;
                    border-radius: 12px;
                    font-size: 14px;
                    font-weight: 500;
                    font-family: 'DM Sans', sans-serif;
                    text-decoration: none;
                    transition: transform 0.15s, opacity 0.15s;
                    cursor: pointer;
                    border: none;
                }
                .btn-action:hover { transform: translateY(-2px); opacity: 0.9; }
                .btn-primary   { background: #1a3a2a; color: #fff; }
                .btn-secondary { background: #f0fdf4; color: '#2d6a4f'; border: 1.5px solid #bbf7d0; }

                @keyframes popIn {
                    0%   { transform: scale(0.5); opacity: 0; }
                    70%  { transform: scale(1.08); }
                    100% { transform: scale(1);    opacity: 1; }
                }
                @keyframes float {
                    0%, 100% { transform: translateY(0); }
                    50%      { transform: translateY(-6px); }
                }
            `}</style>

            <div className="result-wrap">

                {/* ─── Level-up banner (solo si subió de rango) ─── */}
                {result.level_up && levelUpRank && (
                    <div className="levelup-banner">
                        <span className="levelup-icon">{levelUpRank.badge_icon}</span>
                        <div>
                            <div className="levelup-title">¡Subiste de rango! 🎉</div>
                            <div className="levelup-sub">
                                {allRanks.find(r => r.name === result.level_before)?.label ?? result.level_before}
                                {' → '}
                                <strong>{levelUpRank.label}</strong>
                            </div>
                            <div className="levelup-desc">{levelUpRank.description}</div>
                        </div>
                    </div>
                )}

                {/* ─── Main card ─── */}
                <div className={`result-card ${result.level_up ? 'rounded-bottom' : 'rounded'}`}>

                    {/* Hero con puntos */}
                    <div className="result-hero">
                        <div className="hero-label">🌿 ¡Reciclaje registrado!</div>
                        <div className="hero-pts">+{result.points_earned}</div>
                        <div className="hero-pts-lbl">puntos ganados</div>
                        <div className="hero-detail">
                            {result.quantity} × {result.waste_name}
                        </div>
                    </div>

                    {/* Detalles */}
                    <div className="detail-row">
                        <span className="detail-label">Puntos totales</span>
                        <span className="detail-value" style={{ color: '#2d6a4f', fontSize: 17 }}>
                            {(user.total_points ?? 0).toLocaleString()} pts
                        </span>
                    </div>
                    <div className="detail-row">
                        <span className="detail-label">Rango actual</span>
                        <span className="detail-value" style={{ color: currentRank?.badge_color }}>
                            {currentRank?.badge_icon} {currentRank?.label}
                        </span>
                    </div>

                    {/* Barra de progreso al siguiente rango */}
                    <div className="progress-section">
                        <div className="progress-labels">
                            <span>{currentRank?.label}</span>
                            {nextRank
                                ? <span>→ {nextRank.label} en {pointsToNext} pts</span>
                                : <span>¡Rango máximo alcanzado! 🏆</span>
                            }
                        </div>
                        <div className="progress-track">
                            <div
                                className="progress-fill"
                                style={{
                                    width:      `${progress}%`,
                                    background: currentRank?.badge_color ?? '#52b788',
                                }}
                            />
                        </div>
                        <div className="progress-pct">{progress}% completado</div>
                    </div>
                </div>

                {/* ─── Progreso de rangos ─── */}
                <div className="ranks-card">
                    <div style={{ fontSize: 13, fontWeight: 600, color: '#1a3a2a', marginBottom: '0.75rem' }}>
                        Tu progreso en rangos
                    </div>
                    {allRanks.map((r: Rank) => {
                        const unlocked  = (user.total_points ?? 0) >= r.min_points;
                        const isCurrent = r.name === user.level;
                        return (
                            <div
                                key={r.name}
                                className="rank-row"
                                style={{
                                    background:   isCurrent ? `${r.badge_color}12` : 'transparent',
                                    borderColor:  isCurrent ? `${r.badge_color}44` : 'transparent',
                                    opacity:      unlocked ? 1 : 0.45,
                                }}
                            >
                                <span className="rank-icon-big">{r.badge_icon}</span>
                                <div style={{ flex: 1 }}>
                                    <div
                                        className="rank-label"
                                        style={{
                                            fontWeight: isCurrent ? 700 : 400,
                                            color:      isCurrent ? r.badge_color : '#374151',
                                        }}
                                    >
                                        {r.label}
                                    </div>
                                    <div className="rank-pts-lbl">
                                        desde {r.min_points} pts
                                        {r.max_points > 0 ? ` — hasta ${r.max_points} pts` : ''}
                                    </div>
                                </div>
                                {isCurrent && (
                                    <span
                                        className="rank-badge"
                                        style={{
                                            background: `${r.badge_color}22`,
                                            color:      r.badge_color,
                                        }}
                                    >
                                        Actual
                                    </span>
                                )}
                                {!isCurrent && unlocked && <span className="rank-check">✓</span>}
                                {!unlocked && <span className="rank-lock">🔒</span>}
                            </div>
                        );
                    })}
                </div>

                {/* ─── Botones de acción ─── */}
                <div className="action-btns">
                    <Link href={route('recycle.index')} className="btn-action btn-primary">
                        ♻️ Reciclar más
                    </Link>
                    <Link href={route('dashboard')} className="btn-action btn-secondary">
                        📊 Ver dashboard
                    </Link>
                </div>

            </div>
        </AppLayout>
    );
}
