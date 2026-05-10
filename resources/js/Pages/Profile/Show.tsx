import { Head, Link, router, useForm } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps, RecycleAction, RankInfo, Rank } from '@/types';

const CAT_META: Record<string, { label: string; emoji: string; color: string; bg: string }> = {
    PLASTIC:    { label: 'Plástico',    emoji: '🧴', color: '#1d4ed8', bg: '#eff6ff' },
    GLASS:      { label: 'Vidrio',      emoji: '🍶', color: '#0d9488', bg: '#f0fdfa' },
    PAPER:      { label: 'Papel',       emoji: '📄', color: '#a16207', bg: '#fefce8' },
    METAL:      { label: 'Metal',       emoji: '🥫', color: '#3f3f46', bg: '#f4f4f5' },
    ORGANIC:    { label: 'Orgánico',    emoji: '🌿', color: '#15803d', bg: '#f0fdf4' },
    ELECTRONIC: { label: 'Electrónico', emoji: '📱', color: '#7e22ce', bg: '#fdf4ff' },
    OTHER:      { label: 'Otro',        emoji: '♻️', color: '#c2410c', bg: '#fff7ed' },
};

interface ProfileUser {
    id: string; name: string; username: string; email: string;
    level: string; total_points: number; member_since: string;
}
interface Stats {
    total_actions: number; total_points: number;
    total_units: number; unique_materials: number;
}
interface Pagination { total: number; currentPage: number; lastPage: number; perPage: number; }

interface Props extends PageProps {
    profileUser: ProfileUser;
    stats: Stats;
    history: RecycleAction[];
    pagination: Pagination;
    rankInfo: RankInfo;
    status?: string;
}

export default function ProfileShow({ auth, profileUser, stats, history, pagination, rankInfo, status }: Props) {
    const [tab, setTab] = useState<'history' | 'settings' | 'password'>('history');

    const { allRanks, nextRank, progress, pointsToNext } = rankInfo;
    const currentRank = allRanks.find(r => r.name === profileUser.level);

    const infoForm = useForm({ name: profileUser.name, email: profileUser.email });
    const passForm = useForm({ current_password: '', password: '', password_confirmation: '' });

    const memberSince = new Date(profileUser.member_since).toLocaleDateString('es-ES', {
        day: 'numeric', month: 'long', year: 'numeric',
    });

    return (
        <AppLayout header={
            <div style={{ display: 'flex', alignItems: 'center', gap: 14 }}>
                <div style={{ width: 52, height: 52, borderRadius: '50%', background: `${currentRank?.badge_color ?? '#52b788'}22`, display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: 22, border: `2px solid ${currentRank?.badge_color ?? '#52b788'}44` }}>
                    {profileUser.name.charAt(0).toUpperCase()}
                </div>
                <div>
                    <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 20, color: '#1a3a2a', margin: 0 }}>{profileUser.name}</h1>
                    <p style={{ fontSize: 13, color: '#6b7c6d', margin: '2px 0 0', fontWeight: 300 }}>
                        @{profileUser.username} · Miembro desde {memberSince}
                    </p>
                </div>
            </div>
        }>
            <Head title="Mi perfil" />
            <style>{`
                .profile-grid { display:grid; grid-template-columns:300px 1fr; gap:1.25rem; align-items:start; }
                @media(max-width:900px){ .profile-grid { grid-template-columns:1fr; } }
                .card { background:#fff; border-radius:14px; border:1px solid #e8ebe6; }
                .stat-row { display:flex; justify-content:space-between; align-items:center; padding:9px 1.25rem; border-bottom:1px solid #f9faf8; font-size:14px; }
                .stat-row:last-child { border-bottom:none; }
                .tab-bar { display:flex; border-bottom:1px solid #abacaa; }
                .tab-btn { padding:12px 18px; font-size:13.5px; font-weight:500; color:#9ca3af; background:none; border:none; border-bottom:2px solid transparent; cursor:pointer; font-family:'DM Sans',sans-serif; transition:all 0.15s; white-space:nowrap; }
                .tab-btn.active { color:#1a3a2a; border-bottom-color:#2d6a4f; }
                .tab-btn:hover { color:#374151; }
                .hist-row { display:flex; align-items:center; gap:10px; padding:1.3rem 1.25rem; border-bottom:1px solid #abacaa; transition:background 0.1s; }
                .hist-row:last-child { border-bottom:none; }
                .hist-row:hover { background:#fafbf9; }
                .cat-icon { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
                .levelup-tag { display:inline-flex; align-items:center; gap:3px; background:#fdf4ff; color:#7e22ce; padding:1px 7px; border-radius:8px; font-size:11px; font-weight:600; }
                .pagination-bar { display:flex; align-items:center; justify-content:space-between; padding:0.9rem 1.25rem; border-top:1px solid #f0f0ee; font-size:13px; color:#9ca3af; }
                .pag-btn { padding:5px 14px; border:1.5px solid #e0e0e0; border-radius:8px; background:#fff; font-size:13px; cursor:pointer; font-family:'DM Sans',sans-serif; color:#374151; transition:border-color 0.15s; }
                .pag-btn:hover { border-color:#2d6a4f; color:#2d6a4f; }
                .pag-btn:disabled { opacity:0.4; cursor:not-allowed; }
                .formulario-label { display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:5px; }
                .formulario-input { width:100%; height:44px; padding:0 12px; border:1.5px solid #e0e0e0; border-radius:10px; font-size:14px; font-family:'DM Sans',sans-serif; color:#1c1c1c; outline:none; transition:border-color 0.2s; }
                .formulario-input:focus { border-color:#2d6a4f; }
                .formulario-input.err { border-color:#e53e3e; }
                .field-err { font-size:12px; color:#e53e3e; margin-top:4px; }
                .save-btn { height:44px; padding:0 22px; background:#1a3a2a; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; transition:background 0.15s; }
                .save-btn:hover { background:#2d6a4f; }
                .save-btn:disabled { opacity:0.6; cursor:not-allowed; }
                .flash-ok { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; padding:9px 14px; border-radius:9px; font-size:13px; display:flex; align-items:center; gap:7px; margin-bottom:1rem; }
                .empty-hist { padding:2.5rem 1.5rem; text-align:center; }
            `}</style>

            <div className="profile-grid">
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>

                    {/* rango acutal */}
                    <div className="card" style={{ overflow: 'hidden' }}>
                        <div style={{ background: `linear-gradient(135deg,${currentRank?.badge_color ?? '#2d6a4f'}dd,${currentRank?.badge_color ?? '#2d6a4f'})`, padding: '1.5rem', textAlign: 'center' }}>
                            <div style={{ fontSize: 48, marginBottom: 8 }}>{currentRank?.badge_icon}</div>
                            <div style={{ fontFamily: "'DM Serif Display',serif", fontSize: 20, color: '#fff' }}>{currentRank?.label}</div>
                            <div style={{ fontSize: 12, color: 'rgba(255,255,255,0.7)', marginTop: 4 }}>{currentRank?.description}</div>
                            <div style={{ marginTop: 14, background: 'rgba(0,0,0,0.15)', borderRadius: 99, height: 8, overflow: 'hidden' }}>
                                <div style={{ width: `${progress}%`, height: '100%', background: 'rgba(255,255,255,0.8)', borderRadius: 99, transition: 'width 0.6s ease' }} />
                            </div>
                            <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: 5, fontSize: 11, color: 'rgba(255,255,255,0.6)' }}>
                                <span>{profileUser.total_points} pts</span>
                                {nextRank ? <span>→ {nextRank.label} en {pointsToNext} pts</span> : <span>¡Rango máximo! 🎉</span>}
                            </div>
                        </div>
                        {/* display de rangos */}
                        <div style={{ padding: '0.75rem 1rem', display: 'flex', flexDirection: 'column', gap: 5 }}>
                            {allRanks.map((r: Rank) => {
                                const unlocked = profileUser.total_points >= r.min_points;
                                const isCurrent = r.name === profileUser.level;
                                return (
                                    <div key={r.name} style={{ display: 'flex', alignItems: 'center', gap: 8, padding: '5px 8px', borderRadius: 8, background: isCurrent ? `${r.badge_color}12` : 'transparent', opacity: unlocked ? 1 : 0.45 }}>
                                        <span style={{ fontSize: 18 }}>{r.badge_icon}</span>
                                        <span style={{ fontSize: 13, flex: 1, fontWeight: isCurrent ? 600 : 400, color: isCurrent ? r.badge_color : '#6b7c6d' }}>{r.label}</span>
                                        <span style={{ fontSize: 11, color: '#9ca3af' }}>{r.min_points}+</span>
                                        {isCurrent && <span style={{ fontSize: 10, background: `${r.badge_color}22`, color: r.badge_color, padding: '1px 6px', borderRadius: 8, fontWeight: 700 }}>Actual</span>}
                                        {!isCurrent && unlocked && <span style={{ fontSize: 14, color: '#2d6a4f' }}>✓</span>}
                                        {!unlocked && <span style={{ fontSize: 12 }}>🔒</span>}
                                    </div>
                                );
                            })}
                        </div>
                    </div>

                    {/* estadisticas */}
                    <div className="card">
                        <div style={{ padding: '1rem 1.25rem', borderBottom: '1px solid #f0f0ee', fontSize: 13, fontWeight: 600, color: '#1a3a2a' }}>Estadísticas</div>
                        {[
                            { label: 'Puntos totales',     value: `${stats.total_points.toLocaleString()} pts`, color: '#2d6a4f' },
                            { label: 'Reciclajes',          value: stats.total_actions },
                            { label: 'Unidades recicladas', value: stats.total_units.toLocaleString() },
                            { label: 'Materiales distintos',value: stats.unique_materials },
                        ].map((s, i) => (
                            <div key={i} className="stat-row">
                                <span style={{ color: '#6b7c6d' }}>{s.label}</span>
                                <span style={{ fontWeight: 700, color: (s.color as string | undefined) ?? '#1a3a2a' }}>{s.value}</span>
                            </div>
                        ))}
                    </div>

                    
                </div>

                
                <div className="card" style={{ overflow: 'hidden' }}>
                    <div className="tab-bar">
                        {[
                            { key: 'history',  label: `Historial completo (${stats.total_actions})` },
                            { key: 'settings', label: 'Datos personales' },
                            { key: 'password', label: 'Contraseña' },
                        ].map(t => (
                            <button key={t.key} className={`tab-btn${tab === t.key ? ' active' : ''}`}
                                onClick={() => setTab(t.key as typeof tab)}>
                                {t.label}
                            </button>
                        ))}
                    </div>

                    {/* historial */}
                    {tab === 'history' && (
                        <>
                            {history.length === 0 ? (
                                <div className="empty-hist">
                                    <p style={{ color: '#9ca3af', fontSize: 14, margin: 0 }}>
                                        Aún no has registrado ningún reciclaje.<br />
                                        <Link href={route('recycle.index')} style={{ color: '#2d6a4f', fontWeight: 500 }}>¡Empieza ahora!</Link>
                                    </p>
                                </div>
                            ) : (
                                <>
                                    {history.map(a => {
                                        const cm = CAT_META[a.waste_category] ?? CAT_META.OTHER;
                                        return (
                                            <div key={a.id} className="hist-row">
                                                <div className="cat-icon" style={{ background: cm.bg }}>{cm.emoji}</div>
                                                <div style={{ flex: 1, minWidth: 0 }}>
                                                    <div style={{ fontSize: 14, fontWeight: 500, color: '#1a3a2a', overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>
                                                        {a.waste_name}
                                                        
                                                    </div>
                                                    <div style={{ fontSize: 12, color: '#9ca3af', marginTop: 2 }}>
                                                        📍 {a.cp_name} · {a.quantity} uds. · {new Date(a.date).toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' })}
                                                    </div>
                                                    
                                                </div>
                                                <div style={{ textAlign: 'right', flexShrink: 0 }}>
                                                    <div style={{ fontSize: 14, fontWeight: 700, color: '#2d6a4f' }}>+{a.points_earned} pts</div>
                                                    <div style={{ fontSize: 11, color: '#9ca3af' }}>{cm.label}</div>
                                                </div>
                                            </div>
                                        );
                                    })}
                                    {pagination.lastPage > 1 && (
                                        <div className="pagination-bar">
                                            <span>Pág. {pagination.currentPage} / {pagination.lastPage} · {pagination.total} registros</span>
                                            <div style={{ display: 'flex', gap: 6 }}>
                                                <button className="pag-btn" disabled={pagination.currentPage <= 1}
                                                    onClick={() => router.get(route('profile.show'), { page: pagination.currentPage - 1 })}>
                                                    ← Anterior
                                                </button>
                                                <button className="pag-btn" disabled={pagination.currentPage >= pagination.lastPage}
                                                    onClick={() => router.get(route('profile.show'), { page: pagination.currentPage + 1 })}>
                                                    Siguiente →
                                                </button>
                                            </div>
                                        </div>
                                    )}
                                </>
                            )}
                        </>
                    )}

                    {/* ── datos personales ── */}
                    {tab === 'settings' && (
                        <div style={{ padding: '1.5rem' }}>
                            {status === 'profile-updated' && (
                                <div className="flash-ok"><span>✓</span> Perfil actualizado correctamente.</div>
                            )}
                            <form onSubmit={e => { e.preventDefault(); infoForm.patch(route('profile.update')); }}>
                                <div style={{ marginBottom: '1.1rem' }}>
                                    <label className="formulario-label">Nombre completo</label>
                                    <input type="text" className={`formulario-input${infoForm.errors.name ? ' err' : ''}`}
                                        value={infoForm.data.name} onChange={e => infoForm.setData('name', e.target.value)} />
                                    {infoForm.errors.name && <p className="field-err">{infoForm.errors.name}</p>}
                                </div>
                                <div style={{ marginBottom: '1.1rem' }}>
                                    <label className="formulario-label">Correo electrónico</label>
                                    <input type="email" className={`formulario-input${infoForm.errors.email ? ' err' : ''}`}
                                        value={infoForm.data.email} onChange={e => infoForm.setData('email', e.target.value)} />
                                    {infoForm.errors.email && <p className="field-err">{infoForm.errors.email}</p>}
                                </div>
                                <div style={{ marginBottom: '1.5rem' }}>
                                    <label className="formulario-label">Username</label>
                                    <input type="text" className="formulario-input" value={profileUser.username} disabled
                                        style={{ opacity: 0.6, cursor: 'not-allowed' }} />
                                    <p style={{ fontSize: 11, color: '#9ca3af', marginTop: 4 }}>El username no se puede cambiar.</p>
                                </div>
                                <button type="submit" className="save-btn" disabled={infoForm.processing}>
                                    {infoForm.processing ? 'Guardando...' : 'Guardar cambios'}
                                </button>
                            </form>
                        </div>
                    )}

                    {/* ── password ── */}
                    {tab === 'password' && (
                        <div style={{ padding: '1.5rem' }}>
                            {status === 'password-updated' && (
                                <div className="flash-ok"><span>✓</span> Contraseña actualizada correctamente.</div>
                            )}
                            <form onSubmit={e => { e.preventDefault(); passForm.put(route('profile.password')); }}>
                                {[
                                    { key: 'current_password',      label: 'Contraseña actual',         ph: '••••••••' },
                                    { key: 'password',               label: 'Nueva contraseña',           ph: 'Mín. 8 caracteres' },
                                    { key: 'password_confirmation',  label: 'Confirmar nueva contraseña', ph: '••••••••' },
                                ].map(f => (
                                    <div key={f.key} style={{ marginBottom: '1.1rem' }}>
                                        <label className="formulario-label">{f.label}</label>
                                        <input type="password" placeholder={f.ph}
                                            className={`formulario-input${(passForm.errors as any)[f.key] ? ' err' : ''}`}
                                            value={(passForm.data as any)[f.key]}
                                            onChange={e => passForm.setData(f.key as any, e.target.value)} />
                                        {(passForm.errors as any)[f.key] && (
                                            <p className="field-err">{(passForm.errors as any)[f.key]}</p>
                                        )}
                                    </div>
                                ))}
                                <button type="submit" className="save-btn" disabled={passForm.processing}>
                                    {passForm.processing ? 'Actualizando...' : 'Actualizar contraseña'}
                                </button>
                            </form>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
