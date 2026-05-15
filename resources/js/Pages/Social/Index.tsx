import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

// ─── Tipos ───────────────────────────────────────────────────────────────────
interface Equipo {
    id: string;
    name: string;
    slug: string;
    description: string | null;
    emoji: string;
    badge_color: string;
    owner_id: string;
    is_public: boolean;
    max_members: number;
    total_points: number;
    member_count: number;
    is_member: boolean;
    is_owner: boolean;
}

interface EntradaFeed {
    id: string;
    user_id: string;
    user_name: string;
    user_level: string;
    team_id: string | null;
    type: string;
    title: string;
    description: string | null;
    emoji: string;
    points: number;
    meta: Record<string, any>;
    created_at: string;
}

interface Props extends PageProps {
    myTeams: Equipo[];
    publicTeams: Equipo[];
    feed: EntradaFeed[];
}

// ─── Metadatos ───────────────────────────────────────────────────────────────
const COLORES_NIVEL: Record<string, string> = {
    BEGINNER: '#15803d', INTERMEDIATE: '#2d6a4f', ADVANCED: '#1d4ed8', EXPERT: '#7e22ce',
};

const COLORES_FEED: Record<string, { fondo: string; texto: string; etiqueta: string }> = {
    RECYCLE:         { fondo: '#f0fdf4', texto: '#15803d', etiqueta: 'Reciclaje'    },
    LEVEL_UP:        { fondo: '#fdf4ff', texto: '#7e22ce', etiqueta: 'Subida nivel' },
    CHALLENGE_DONE:  { fondo: '#fefce8', texto: '#a16207', etiqueta: 'Reto completado' },
    REWARD_UNLOCKED: { fondo: '#eff6ff', texto: '#1d4ed8', etiqueta: 'Recompensa'   },
    TEAM_JOINED:     { fondo: '#f0f9ff', texto: '#0369a1', etiqueta: 'Equipo unido' },
};

// ─── CSS ─────────────────────────────────────────────────────────────────────
const CSS = `
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; }

.social-pagina { display: grid; grid-template-columns: 1fr 300px; gap: 1.25rem; align-items: start; }
@media(max-width:960px){ .social-pagina { grid-template-columns: 1fr; } .social-barra-lateral { order: -1; } }

.social-heroe { background: linear-gradient(135deg, #0c4a6e, #0369a1, #0284c7); border-radius: 16px; padding: 1.75rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 1.5rem; }
@media(max-width:600px){ .social-heroe { flex-direction: column; text-align: center; } }
.social-heroe-icono { font-size: 52px; flex-shrink: 0; animation: flotar 3s ease infinite; }
.social-heroe-titulo { font-family: 'DM Serif Display', serif; font-size: 22px; color: #fff; margin-bottom: 4px; }
.social-heroe-subtitulo { font-size: 13px; color: rgba(255,255,255,0.65); font-weight: 300; }

.pestanas-fila { display: flex; gap: 2px; margin-bottom: 1.25rem; border-bottom: 2px solid #e8ebe6; }
.pestana-btn { padding: 9px 18px; font-size: 13px; font-weight: 500; color: #6b7c6d; background: none; border: none; cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif; border-bottom: 2px solid transparent; margin-bottom: -2px; }
.pestana-btn.activa { color: #0369a1; border-bottom-color: #0369a1; }
.pestana-btn:hover { color: #0369a1; }

.equipos-cuadricula { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 12px; }

.equipo-tarjeta { background: #fff; border-radius: 14px; border: 2px solid #e8ebe6; padding: 1.25rem; transition: all 0.2s; position: relative; }
.equipo-tarjeta:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
.equipo-tarjeta.miembro { border-color: currentColor; }
.equipo-cabecera { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
.equipo-emoji { font-size: 32px; flex-shrink: 0; }
.equipo-nombre { font-size: 15px; font-weight: 700; color: #1a3a2a; }
.equipo-descripcion { font-size: 12px; color: #9ca3af; margin-top: 2px; font-weight: 300; line-height: 1.4; }
.equipo-estadisticas { display: flex; gap: 12px; margin-bottom: 10px; font-size: 12px; color: #6b7c6d; }
.equipo-stat-valor { font-weight: 700; color: #1a3a2a; }
.equipo-etiquetas { position: absolute; top: 12px; right: 12px; display: flex; gap: 4px; }
.equipo-etiqueta { font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px; }

.formulario-crear { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; padding: 1.5rem; margin-bottom: 1.25rem; }
.formulario-titulo { font-family: 'DM Serif Display', serif; font-size: 18px; color: #1a3a2a; margin-bottom: 1rem; }
.formulario-fila { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }
.formulario-grupo { display: flex; flex-direction: column; gap: 4px; margin-bottom: 10px; }
.formulario-etiqueta { font-size: 12px; font-weight: 600; color: #6b7c6d; text-transform: uppercase; letter-spacing: 0.4px; }
.formulario-campo { height: 40px; border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0 12px; font-size: 14px; font-family: 'DM Sans', sans-serif; outline: none; transition: border 0.15s; color: #1a3a2a; }
.formulario-campo:focus { border-color: #0369a1; }
.formulario-textarea { border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 10px 12px; font-size: 14px; font-family: 'DM Sans', sans-serif; outline: none; resize: vertical; min-height: 70px; transition: border 0.15s; color: #1a3a2a; width: 100%; }
.formulario-textarea:focus { border-color: #0369a1; }

.feed-lista { display: flex; flex-direction: column; gap: 10px; }
.feed-entrada { background: #fff; border-radius: 12px; border: 1px solid #e8ebe6; padding: 1rem 1.25rem; display: flex; gap: 12px; align-items: flex-start; }
.feed-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0; }
.feed-contenido { flex: 1; }
.feed-titulo { font-size: 14px; font-weight: 600; color: #1a3a2a; margin-bottom: 2px; }
.feed-descripcion { font-size: 12px; color: #6b7c6d; font-weight: 300; }
.feed-derecha { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
.feed-etiqueta-tipo { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
.feed-hora { font-size: 11px; color: #9ca3af; }
.feed-puntos { font-size: 13px; font-weight: 700; color: #15803d; }

.barra-lateral-caja { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; padding: 1.1rem 1.25rem; }
.barra-lateral-caja + .barra-lateral-caja { margin-top: 1rem; }
.barra-lateral-titulo { font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 10px; }

.boton { display: inline-flex; align-items: center; justify-content: center; gap: 5px; height: 34px; padding: 0 14px; border-radius: 8px; font-size: 12px; font-weight: 600; font-family: 'DM Sans', sans-serif; border: none; cursor: pointer; transition: all 0.15s; text-decoration: none; }
.boton-principal { background: #0369a1; color: #fff; }
.boton-principal:hover { background: #0284c7; }
.boton-peligro { background: #fef2f2; color: #dc2626; border: 1.5px solid #fecaca; }
.boton-peligro:hover { background: #fee2e2; }


.estado-vacio { padding: 2.5rem; text-align: center; background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; }

@keyframes flotar { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
`;

// ─── Componente ───────────────────────────────────────────────────────────────
export default function SocialIndex({ myTeams, publicTeams, feed }: Props) {
    const [pestana,        setPestana]        = useState<'feed' | 'mis-equipos' | 'explorar' | 'crear'>('feed');
    const [nuevoEmoji,     setNuevoEmoji]     = useState('♻️');
    const [nuevoColor,     setNuevoColor]     = useState('#2d6a4f');
    const [nuevoNombre,    setNuevoNombre]    = useState('');
    const [nuevoDesc,      setNuevoDesc]      = useState('');
    const [nuevoPublico,   setNuevoPublico]   = useState(true);

    const crearEquipo = () => {
        if (!nuevoNombre.trim()) return;
        router.post(route('teams.create'), {
            name:        nuevoNombre,
            description: nuevoDesc,
            emoji:       nuevoEmoji,
            badge_color: nuevoColor,
            is_public:   nuevoPublico,
        });
    };

    const unirse  = (id: string) => router.post(route('teams.join'),  { team_id: id });
    const salir   = (id: string) => router.post(route('teams.leave'), { team_id: id });

    const TarjetaEquipo = ({ equipo }: { equipo: Equipo }) => (
        <div
            className={`equipo-tarjeta${equipo.is_member ? ' miembro' : ''}`}
            style={{ color: equipo.badge_color }}
        >
            <div className="equipo-etiquetas">
                {equipo.is_owner  && <span className="equipo-etiqueta" style={{ background: `${equipo.badge_color}22`, color: equipo.badge_color }}>Fundador</span>}
                {equipo.is_member && !equipo.is_owner && <span className="equipo-etiqueta" style={{ background: '#f0f9ff', color: '#0369a1' }}>Miembro</span>}
                {equipo.is_public && <span className="equipo-etiqueta" style={{ background: '#f9fafb', color: '#6b7c6d' }}>Público</span>}
            </div>

            <div className="equipo-cabecera">
                <span className="equipo-emoji">{equipo.emoji}</span>
                <div>
                    <div className="equipo-nombre">{equipo.name}</div>
                    {equipo.description && <div className="equipo-descripcion">{equipo.description}</div>}
                </div>
            </div>

            <div className="equipo-estadisticas">
                <span><span className="equipo-stat-valor">{equipo.member_count}</span>/{equipo.max_members} miembros</span>
                <span> <span className="equipo-stat-valor">{equipo.total_points.toLocaleString()}</span> pts</span>
            </div>

            <div style={{ display: 'flex', gap: 6 }}>
                {!equipo.is_member && equipo.member_count < equipo.max_members && (
                    <button className="boton boton-principal" onClick={() => unirse(equipo.id)}>
                        + Unirme
                    </button>
                )}
                {equipo.is_member && !equipo.is_owner && (
                    <button className="boton boton-peligro" onClick={() => salir(equipo.id)}>
                        Salir del equipo
                    </button>
                )}
                {equipo.member_count >= equipo.max_members && !equipo.is_member && (
                    <span className="boton" style={{ background: '#f9fafb', color: '#9ca3af', cursor: 'default' }}>
                        Equipo lleno
                    </span>
                )}
            </div>
        </div>
    );

    return (
        <AppLayout header={
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <div>
                    <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 21, color: '#0c4a6e', margin: 0 }}>
                        Social
                    </h1>
                    <p style={{ fontSize: 13, color: '#6b7c6d', margin: '3px 0 0', fontWeight: 300 }}>
                        {myTeams.length} equipo{myTeams.length !== 1 ? 's' : ''} · {feed.length} actividades recientes
                    </p>
                </div>
                <Link href={route('leaderboard.index')} style={{ display: 'flex', alignItems: 'center', gap: 6, padding: '7px 14px', borderRadius: 9, background: '#f0f9ff', color: '#0369a1', border: '1.5px solid #bae6fd', fontSize: 13, fontWeight: 500, textDecoration: 'none' }}>
                    Clasificación
                </Link>
            </div>
        }>
            <Head title="Social" />
            <style>{CSS}</style>


            <div className="social-heroe">
                <span className="social-heroe-icono"></span>
                <div>
                    <div className="social-heroe-titulo">Recicla con tu equipo</div>
                    <div className="social-heroe-subtitulo">
                        Crea equipos, únete a otros recicladores y compite juntos en la clasificación.
                    </div>
                </div>
            </div>

            <div className="social-pagina">

                <div>

                    <div className="pestanas-fila">
                        {[
                            { clave: 'feed',       etiqueta: ` Actividad` },
                            { clave: 'mis-equipos',etiqueta: ` Mis equipos (${myTeams.length})` },
                            { clave: 'explorar',   etiqueta: ` Explorar` },
                            { clave: 'crear',      etiqueta: ` Crear equipo` },
                        ].map(p => (
                            <button
                                key={p.clave}
                                className={`pestana-btn${pestana === p.clave ? ' activa' : ''}`}
                                onClick={() => setPestana(p.clave as any)}
                            >
                                {p.etiqueta}
                            </button>
                        ))}
                    </div>


                    {pestana === 'feed' && (
                        feed.length === 0 ? (
                            <div className="estado-vacio">
                                <div style={{ fontSize: 36, marginBottom: 8 }}>📭</div>
                                <p style={{ color: '#9ca3af', fontSize: 14, margin: 0 }}>
                                    Únete a un equipo para ver su actividad aquí.
                                </p>
                            </div>
                        ) : (
                            <div className="feed-lista">
                                {feed.map(entrada => {
                                    const cf = COLORES_FEED[entrada.type] ?? COLORES_FEED.RECYCLE;
                                    const cn = COLORES_NIVEL[entrada.user_level] ?? '#6b7c6d';
                                    return (
                                        <div key={entrada.id} className="feed-entrada">
                                            <div className="feed-avatar" style={{ background: cn }}>
                                                {entrada.user_name.charAt(0).toUpperCase()}
                                            </div>
                                            <div className="feed-contenido">
                                                <div className="feed-titulo">{entrada.emoji} {entrada.title}</div>
                                                {entrada.description && (
                                                    <div className="feed-descripcion">{entrada.description}</div>
                                                )}
                                            </div>
                                            <div className="feed-derecha">
                                                <span className="feed-etiqueta-tipo" style={{ background: cf.fondo, color: cf.texto }}>
                                                    {cf.etiqueta}
                                                </span>
                                                {entrada.points > 0 && (
                                                    <span className="feed-puntos">+{entrada.points} pts</span>
                                                )}
                                                <span className="feed-hora">{entrada.created_at}</span>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        )
                    )}


                    {pestana === 'mis-equipos' && (
                        myTeams.length === 0 ? (
                            <div className="estado-vacio">
                                <div style={{ fontSize: 36, marginBottom: 8 }}>👥</div>
                                <p style={{ color: '#9ca3af', fontSize: 14, margin: '0 0 14px' }}>
                                    Aún no perteneces a ningún equipo.
                                </p>
                                <button className="boton boton-principal" onClick={() => setPestana('explorar')}>
                                     Explorar equipos
                                </button>
                            </div>
                        ) : (
                            <div className="equipos-cuadricula">
                                {myTeams.map(e => <TarjetaEquipo key={e.id} equipo={e}/>)}
                            </div>
                        )
                    )}

                    {pestana === 'explorar' && (
                        publicTeams.length === 0 ? (
                            <div className="estado-vacio">
                                <div style={{ fontSize: 36, marginBottom: 8 }}></div>
                                <p style={{ color: '#9ca3af', fontSize: 14, margin: '0 0 14px' }}>
                                    No hay equipos públicos aún. ¡Sé el primero!
                                </p>
                                <button className="boton boton-principal" onClick={() => setPestana('crear')}>
                                     Crear equipo
                                </button>
                            </div>
                        ) : (
                            <div className="equipos-cuadricula">
                                {publicTeams.map(e => <TarjetaEquipo key={e.id} equipo={e}/>)}
                            </div>
                        )
                    )}


                    {pestana === 'crear' && (
                        <div className="formulario-crear">
                            <div className="formulario-titulo">Crear nuevo equipo</div>

                            <div className="formulario-fila">
                                <div className="formulario-grupo">
                                    <label className="formulario-etiqueta">Nombre *</label>
                                    <input
                                        className="formulario-campo"
                                        placeholder="Ej: Los Verdes de Valencia"
                                        value={nuevoNombre}
                                        onChange={e => setNuevoNombre(e.target.value)}
                                    />
                                </div>
                                <div className="formulario-grupo">
                                    <label className="formulario-etiqueta">Emoji</label>
                                    <input
                                        className="formulario-campo"
                                        placeholder="♻️"
                                        value={nuevoEmoji}
                                        onChange={e => setNuevoEmoji(e.target.value)}
                                        maxLength={5}
                                    />
                                </div>
                            </div>

                            <div className="formulario-grupo">
                                <label className="formulario-etiqueta">Descripción</label>
                                <textarea
                                    className="formulario-textarea"
                                    placeholder="Cuéntanos sobre tu equipo..."
                                    value={nuevoDesc}
                                    onChange={e => setNuevoDesc(e.target.value)}
                                    maxLength={200}
                                />
                            </div>

                            <div className="formulario-fila">
                                <div className="formulario-grupo">
                                    <label className="formulario-etiqueta">Visibilidad</label>
                                    <label style={{ display: 'flex', alignItems: 'center', gap: 8, fontSize: 13, cursor: 'pointer', color: '#374151' }}>
                                        <input
                                            type="checkbox"
                                            checked={nuevoPublico}
                                            onChange={e => setNuevoPublico(e.target.checked)}
                                            style={{ accentColor: '#0369a1', width: 16, height: 16 }}
                                        />
                                        Equipo público
                                    </label>
                                </div>
                            </div>

                            {nuevoNombre && (
                                <div style={{ background: '#f9faf8', borderRadius: 10, padding: '12px 14px', marginBottom: 14, border: `2px solid ${nuevoColor}44` }}>
                                    <div style={{ fontSize: 12, color: '#9ca3af', marginBottom: 6, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.4px' }}>
                                        Vista previa
                                    </div>
                                    <div style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
                                        <span style={{ fontSize: 28 }}>{nuevoEmoji}</span>
                                        <div>
                                            <div style={{ fontSize: 15, fontWeight: 700, color: '#1a3a2a' }}>{nuevoNombre}</div>
                                            {nuevoDesc && <div style={{ fontSize: 12, color: '#9ca3af', fontWeight: 300 }}>{nuevoDesc}</div>}
                                        </div>
                                    </div>
                                </div>
                            )}

                            <button
                                className="boton boton-principal"
                                style={{ height: 42, width: '100%', fontSize: 14 }}
                                onClick={crearEquipo}
                                disabled={!nuevoNombre.trim()}
                            >
                                 Crear equipo
                            </button>
                        </div>
                    )}
                </div>


                <div className="social-barra-lateral">
                    <div className="barra-lateral-caja">
                        <div className="barra-lateral-titulo">Mis equipos</div>
                        {myTeams.length === 0 ? (
                            <p style={{ fontSize: 13, color: '#9ca3af', margin: 0 }}>Sin equipos aún.</p>
                        ) : (
                            myTeams.map(e => (
                                <div key={e.id} style={{ display: 'flex', alignItems: 'center', gap: 8, padding: '7px 0', borderBottom: '1px solid #f5f5f3', fontSize: 13 }}>
                                    <span style={{ fontSize: 18 }}>{e.emoji}</span>
                                    <div style={{ flex: 1 }}>
                                        <div style={{ fontWeight: 600, color: '#1a3a2a' }}>{e.name}</div>
                                        <div style={{ fontSize: 11, color: '#9ca3af' }}>
                                            {e.member_count} miembros · {e.total_points.toLocaleString()} pts
                                        </div>
                                    </div>
                                    {e.is_owner && (
                                        <span style={{ fontSize: 10, background: `${e.badge_color}22`, color: e.badge_color, padding: '1px 6px', borderRadius: 20, fontWeight: 700 }}>
                                            Fundador
                                        </span>
                                    )}
                                </div>
                            ))
                        )}
                        <button
                            className="boton boton-principal"
                            style={{ width: '100%', marginTop: 10, height: 36 }}
                            onClick={() => setPestana('crear')}
                        >
                             Crear equipo
                        </button>
                    </div>

                    <div className="barra-lateral-caja">
                        <div className="barra-lateral-titulo">Comunidad</div>
                        {[
                            { etiqueta: 'Equipos públicos', valor: publicTeams.length },
                            { etiqueta: 'Mis equipos',      valor: myTeams.length     },
                            { etiqueta: 'Actividad reciente',valor: feed.length       },
                        ].map((s, i) => (
                            <div key={i} style={{ display: 'flex', justifyContent: 'space-between', padding: '7px 0', borderBottom: i < 2 ? '1px solid #f5f5f3' : 'none', fontSize: 13 }}>
                                <span style={{ color: '#6b7c6d' }}>{s.etiqueta}</span>
                                <span style={{ fontWeight: 700, color: '#0369a1' }}>{s.valor}</span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}