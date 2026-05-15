import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface Recompensa {
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
    rewards: Recompensa[];
    userPoints: number;
    unlockedCount: number;
    totalRewards: number;
    nextReward: Recompensa | null;
    pointsToNext: number | null;
}

const CATEGORIAS = ['ALL', 'DISCOUNT', 'EXPERIENCE', 'DONATION'] as const;

const META_CATEGORIAS: Record<string, { etiqueta: string; color: string; fondo: string }> = {
    ALL:        { etiqueta: 'Todas',        color: '#1a3a2a', fondo: '#f0fdf4' },
    DISCOUNT:   { etiqueta: 'Descuentos',   color: '#a16207', fondo: '#fefce8' },
    EXPERIENCE: { etiqueta: 'Experiencias', color: '#7e22ce', fondo: '#fdf4ff' },
    DONATION:   { etiqueta: 'Donaciones',   color: '#15803d', fondo: '#f0fdf4' },
};

const CSS = `
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; }

.recompensas-pagina { display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem; align-items: start; }
@media(max-width:960px){ .recompensas-pagina { grid-template-columns: 1fr; } .recompensas-barra-lateral { order: -1; } }

.recompensas-heroe { background: linear-gradient(135deg, #1a3a2a, #2d6a4f); border-radius: 16px; padding: 1.75rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 1.5rem; }
@media(max-width:600px){ .recompensas-heroe { flex-direction: column; text-align: center; gap: 1rem; } }
.heroe-titulo { font-family: 'DM Serif Display', serif; font-size: 24px; color: #fff; letter-spacing: -0.5px; margin-bottom: 4px; }
.heroe-subtitulo { font-size: 14px; color: rgba(255,255,255,0.65); margin-bottom: 12px; font-weight: 300; }
.heroe-barra-fondo { background: rgba(0,0,0,0.2); border-radius: 99px; height: 10px; overflow: hidden; width: 100%; max-width: 320px; }
.heroe-barra-relleno { height: 100%; border-radius: 99px; background: #52b788; transition: width 0.8s ease; }
.heroe-barra-etiquetas { display: flex; justify-content: space-between; font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 5px; max-width: 320px; }

.filtros-fila { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; align-items: center; }
.filtro-boton { padding: 5px 13px; border-radius: 20px; border: 1.5px solid #e0e0e0; background: #fff; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif; color: #6b7c6d; }
.filtro-boton:hover { border-color: #2d6a4f; color: #2d6a4f; }
.filtro-boton.activo { background: #1a3a2a; color: #fff; border-color: #1a3a2a; }
.interruptor-bloqueadas { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #6b7c6d; cursor: pointer; margin-left: auto; background: none; border: none; font-family: 'DM Sans', sans-serif; }
.interruptor-bloqueadas input { accent-color: #2d6a4f; width: 15px; height: 15px; cursor: pointer; }

.cuadricula-recompensas { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }

.tarjeta-recompensa { border-radius: 16px; border: 2px solid; padding: 1.25rem; text-align: center; cursor: pointer; transition: all 0.2s; position: relative; overflow: hidden; }
.tarjeta-recompensa.desbloqueada:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.tarjeta-recompensa.bloqueada { opacity: 0.62; cursor: default; }
.tarjeta-recompensa.bloqueada:hover { opacity: 0.75; }
.tarjeta-recompensa.seleccionada { box-shadow: 0 0 0 3px currentColor; }
.tarjeta-emoji { font-size: 40px; margin-bottom: 8px; line-height: 1; }
.tarjeta-nombre { font-size: 13px; font-weight: 700; color: #1a3a2a; margin-bottom: 4px; line-height: 1.3; }
.tarjeta-categoria { font-size: 11px; color: #9ca3af; margin-bottom: 8px; }
.tarjeta-puntos { font-size: 12px; font-weight: 700; }
.insignia-desbloqueada { position: absolute; top: 10px; right: 10px; background: #22c55e; color: #fff; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 12px; }
.insignia-bloqueada { position: absolute; top: 10px; right: 10px; font-size: 16px; opacity: 0.4; }
.insignia-nueva { position: absolute; top: 10px; left: 10px; background: #f59e0b; color: #fff; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 20px; letter-spacing: 0.5px; text-transform: uppercase; }
.barra-mini { background: rgba(0,0,0,0.08); border-radius: 99px; height: 4px; overflow: hidden; margin-top: 8px; }
.barra-mini-relleno { height: 100%; border-radius: 99px; }

.panel-detalle { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; overflow: hidden; position: sticky; top: 80px; }
.panel-cabecera { padding: 1.5rem; text-align: center; }
.panel-emoji { font-size: 64px; line-height: 1; margin-bottom: 10px; }
.panel-titulo { font-family: 'DM Serif Display', serif; font-size: 20px; color: #1a3a2a; margin-bottom: 4px; letter-spacing: -0.3px; }
.panel-categoria-etiqueta { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 12px; }
.panel-descripcion { font-size: 14px; color: #6b7c6d; line-height: 1.65; font-weight: 300; }
.panel-cuerpo { padding: 0 1.25rem 1.25rem; }
.panel-fila { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f9faf8; font-size: 14px; }
.panel-fila:last-child { border-bottom: none; }
.panel-etiqueta { color: #6b7c6d; }
.panel-valor { font-weight: 600; color: #1a3a2a; }

.caja-proxima { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; padding: 1.1rem 1.25rem; margin-bottom: 1.25rem; }
.proxima-titulo { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 8px; }
.proxima-fila { display: flex; align-items: center; gap: 10px; }
.proxima-nombre { font-size: 14px; font-weight: 600; color: #1a3a2a; margin-bottom: 2px; }
.proxima-puntos { font-size: 12px; color: #6b7c6d; }
.proxima-barra-fondo { background: #f0f0ee; border-radius: 99px; height: 6px; overflow: hidden; margin-top: 10px; }
.proxima-barra-relleno { height: 100%; border-radius: 99px; transition: width 0.6s ease; }

.estado-vacio { padding: 3rem 2rem; text-align: center; background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; }
.sin-seleccion { padding: 3rem 1.5rem; text-align: center; }

@keyframes flotar { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
@keyframes aparicion { 0%{transform:scale(0.8);opacity:0} 100%{transform:scale(1);opacity:1} }
.nueva { animation: aparicion 0.4s cubic-bezier(0.34,1.56,0.64,1) forwards; }
`;

export default function RecompensasIndex({ rewards, userPoints, unlockedCount, totalRewards, nextReward, pointsToNext }: Props) {
    const [filtro,          setFiltro]          = useState<string>('ALL');
    const [mostrarBloqueadas, setMostrarBloqueadas] = useState(true);
    const [seleccionada,    setSeleccionada]    = useState<Recompensa | null>(null);

    const filtradas = rewards.filter(r => {
        const coincideCategoria = filtro === 'ALL' || r.category === filtro;
        const coincideBloqueada = mostrarBloqueadas || r.unlocked;
        return coincideCategoria && coincideBloqueada;
    });

    const porcentajeTotal = Math.round((unlockedCount / Math.max(totalRewards, 1)) * 100);

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
            <style>{CSS}</style>

            <div className="recompensas-heroe">
                <div style={{ flex: 1 }}>
                    <div className="heroe-titulo">
                        {unlockedCount === totalRewards
                            ? 'Coleccion completa'
                            : `${unlockedCount} recompensa${unlockedCount !== 1 ? 's' : ''} desbloqueada${unlockedCount !== 1 ? 's' : ''}`}
                    </div>
                    <div className="heroe-subtitulo">
                        {nextReward
                            ? `Faltan ${pointsToNext} pts para tu proxima recompensa: ${nextReward.name}`
                            : 'Has desbloqueado todas las recompensas disponibles'}
                    </div>
                    <div className="heroe-barra-fondo">
                        <div className="heroe-barra-relleno" style={{ width: `${porcentajeTotal}%` }} />
                    </div>
                    <div className="heroe-barra-etiquetas">
                        <span>{unlockedCount}/{totalRewards} desbloqueadas</span>
                        <span>{porcentajeTotal}%</span>
                    </div>
                </div>
            </div>

            <div className="recompensas-pagina">
                <div>
                    <div className="filtros-fila">
                        {CATEGORIAS.map(cat => {
                            const meta = META_CATEGORIAS[cat];
                            return (
                                <button
                                    key={cat}
                                    className={`filtro-boton${filtro === cat ? ' activo' : ''}`}
                                    onClick={() => setFiltro(cat)}
                                >
                                    {meta.etiqueta}
                                </button>
                            );
                        })}
                        <label className="interruptor-bloqueadas">
                            <input
                                type="checkbox"
                                checked={mostrarBloqueadas}
                                onChange={e => setMostrarBloqueadas(e.target.checked)}
                            />
                            Mostrar bloqueadas
                        </label>
                    </div>

                    <div style={{ fontSize: 12, color: '#9ca3af', marginBottom: 10 }}>
                        {filtradas.filter(r => r.unlocked).length} desbloqueadas · {filtradas.filter(r => !r.unlocked).length} bloqueadas
                    </div>

                    {filtradas.length === 0 ? (
                        <div className="estado-vacio">
                            <p style={{ color: '#9ca3af', fontSize: 14, margin: 0 }}>
                                No hay recompensas con este filtro.
                            </p>
                        </div>
                    ) : (
                        <div className="cuadricula-recompensas">
                            {filtradas.map(r => {
                                const meta    = META_CATEGORIAS[r.category] ?? META_CATEGORIAS.ALL;
                                const pct     = r.unlocked ? 100 : Math.min(100, Math.round(((r.points_required - r.pts_missing) / r.points_required) * 100));
                                const esSel   = seleccionada?.id === r.id;
                                return (
                                    <div
                                        key={r.id}
                                        className={`tarjeta-recompensa ${r.unlocked ? 'desbloqueada' : 'bloqueada'}${esSel ? ' seleccionada' : ''}${r.newly_unlocked ? ' nueva' : ''}`}
                                        style={{
                                            borderColor: r.unlocked ? `${r.badge_color}44` : '#e8ebe6',
                                            background:  r.unlocked ? `${r.badge_color}08` : '#fafaf9',
                                            color:       r.badge_color,
                                        }}
                                        onClick={() => r.unlocked && setSeleccionada(esSel ? null : r)}
                                    >
                                        {r.newly_unlocked && <span className="insignia-nueva">Nueva</span>}
                                        {r.unlocked
                                            ? <span className="insignia-desbloqueada">✓</span>
                                            : <span className="insignia-bloqueada">🔒</span>
                                        }
                                        <div className="tarjeta-emoji">{r.emoji}</div>
                                        <div className="tarjeta-nombre">{r.name}</div>
                                        <div className="tarjeta-categoria">{meta.etiqueta}</div>
                                        <div className="tarjeta-puntos" style={{ color: r.unlocked ? r.badge_color : '#9ca3af' }}>
                                            {r.unlocked
                                                ? 'Desbloqueada'
                                                : r.pts_missing > 0
                                                    ? `Faltan ${r.pts_missing} pts`
                                                    : 'Lista para desbloquear'}
                                        </div>
                                        {!r.unlocked && (
                                            <div className="barra-mini">
                                                <div className="barra-mini-relleno" style={{ width: `${pct}%`, background: r.badge_color }} />
                                            </div>
                                        )}
                                    </div>
                                );
                            })}
                        </div>
                    )}
                </div>

                <div className="recompensas-barra-lateral">
                    {nextReward && (
                        <div className="caja-proxima">
                            <div className="proxima-titulo">Proxima recompensa</div>
                            <div className="proxima-fila">
                                <span style={{ fontSize: 30, flexShrink: 0 }}>{nextReward.emoji}</span>
                                <div style={{ flex: 1 }}>
                                    <div className="proxima-nombre">{nextReward.name}</div>
                                    <div className="proxima-puntos">
                                        {userPoints.toLocaleString()} / {nextReward.points_required.toLocaleString()} pts
                                    </div>
                                </div>
                            </div>
                            <div className="proxima-barra-fondo">
                                <div className="proxima-barra-relleno" style={{
                                    width:      `${Math.min(100, Math.round((userPoints / nextReward.points_required) * 100))}%`,
                                    background: nextReward.badge_color,
                                }} />
                            </div>
                            <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: 11, color: '#9ca3af', marginTop: 4 }}>
                                <span>{Math.min(100, Math.round((userPoints / nextReward.points_required) * 100))}% completado</span>
                                <span>Faltan {pointsToNext} pts</span>
                            </div>
                            <Link href={route('recycle.index')} style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 6, marginTop: 12, height: 40, background: '#1a3a2a', color: '#fff', borderRadius: 9, fontSize: 13, fontWeight: 500, textDecoration: 'none', fontFamily: "'DM Sans',sans-serif" }}>
                                Reciclar para ganar puntos
                            </Link>
                        </div>
                    )}

                    <div className="panel-detalle">
                        {seleccionada ? (
                            <>
                                <div className="panel-cabecera" style={{ borderBottom: '1px solid #f0f0ee', background: `${seleccionada.badge_color}08` }}>
                                    <div className="panel-emoji">{seleccionada.emoji}</div>
                                    <div className="panel-titulo">{seleccionada.name}</div>
                                    {(() => {
                                        const meta = META_CATEGORIAS[seleccionada.category] ?? META_CATEGORIAS.ALL;
                                        return (
                                            <div className="panel-categoria-etiqueta" style={{ background: meta.fondo, color: meta.color }}>
                                                {meta.etiqueta}
                                            </div>
                                        );
                                    })()}
                                    <div className="panel-descripcion">{seleccionada.description}</div>
                                </div>
                                <div className="panel-cuerpo">
                                    <div className="panel-fila">
                                        <span className="panel-etiqueta">Estado</span>
                                        <span className="panel-valor" style={{ color: '#22c55e' }}>Desbloqueada</span>
                                    </div>
                                    <div className="panel-fila">
                                        <span className="panel-etiqueta">Puntos necesarios</span>
                                        <span className="panel-valor">{seleccionada.points_required.toLocaleString()} pts</span>
                                    </div>
                                </div>
                                <div style={{ padding: '0 1.25rem 1.25rem' }}>
                                    <div style={{ background: '#f0fdf4', border: '1px solid #bbf7d0', borderRadius: 10, padding: '10px 14px', fontSize: 13, color: '#15803d' }}>
                                        Recompensa desbloqueada. Contacta con nosotros para canjearla.
                                    </div>
                                </div>
                            </>
                        ) : (
                            <div className="sin-seleccion">
                                <p style={{ fontSize: 14, color: '#9ca3af', margin: 0, lineHeight: 1.6 }}>
                                    Haz clic en una recompensa desbloqueada para ver sus detalles
                                </p>
                            </div>
                        )}
                    </div>

                    <div style={{ background: '#fff', borderRadius: 14, border: '1px solid #e8ebe6', padding: '1.1rem 1.25rem', marginTop: '1rem' }}>
                        <div style={{ fontSize: 13, fontWeight: 600, color: '#1a3a2a', marginBottom: '0.75rem' }}>Resumen</div>
                        {[
                            { etiqueta: 'Puntos acumulados',        valor: `${userPoints.toLocaleString()} pts`, color: '#2d6a4f' },
                            { etiqueta: 'Recompensas desbloqueadas', valor: `${unlockedCount}/${totalRewards}` },
                            { etiqueta: 'Progreso total',            valor: `${porcentajeTotal}%` },
                        ].map((s, i) => (
                            <div key={i} style={{ display: 'flex', justifyContent: 'space-between', padding: '7px 0', borderBottom: i < 2 ? '1px solid #f9faf8' : 'none', fontSize: 13 }}>
                                <span style={{ color: '#6b7c6d' }}>{s.etiqueta}</span>
                                <span style={{ fontWeight: 700, color: s.color ?? '#1a3a2a' }}>{s.valor}</span>
                            </div>
                        ))}
                        <Link href={route('dashboard')} style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 6, marginTop: 12, height: 38, background: '#f0fdf4', color: '#2d6a4f', borderRadius: 9, fontSize: 13, fontWeight: 500, textDecoration: 'none', border: '1.5px solid #bbf7d0', fontFamily: "'DM Sans',sans-serif" }}>
                            Ir al panel principal
                        </Link>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}