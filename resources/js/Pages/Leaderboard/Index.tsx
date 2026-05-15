import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface EntradaClasificacion {
    id: string;
    name: string;
    username: string;
    level: string;
    score: number;
    position: number;
}

interface Periodo {
    value: string;
    label: string;
    emoji: string;
}

interface EntradaHistorial {
    period_key: string;
    points: number;
    position: number;
}

interface Props extends PageProps {
    ranking: EntradaClasificacion[];
    podium: EntradaClasificacion[];
    restRanking: EntradaClasificacion[];
    userPosition: number;
    userInRanking: EntradaClasificacion | null;
    userHistory: EntradaHistorial[];
    currentPeriod: string;
    periods: Periodo[];
    currentUser: { id: string; name: string; level: string; total_points: number };
}

const COLORES_NIVEL: Record<string, { fondo: string; texto: string }> = {
    BEGINNER:     { fondo: '#f0fdf4', texto: '#15803d' },
    INTERMEDIATE: { fondo: '#dcfce7', texto: '#166534' },
    ADVANCED:     { fondo: '#eff6ff', texto: '#1d4ed8' },
    EXPERT:       { fondo: '#fdf4ff', texto: '#7e22ce' },
};

const MEDALLA: Record<number, string> = { 1: '🥇', 2: '🥈', 3: '🥉' };

const TAMANIO_PODIO: Record<number, { alto: string; margenSuperior: string; anillo: string }> = {
    1: { alto: '120px', margenSuperior: '0px',  anillo: '#fbbf24' },
    2: { alto: '90px',  margenSuperior: '30px', anillo: '#9ca3af' },
    3: { alto: '75px',  margenSuperior: '45px', anillo: '#b45309' },
};

const CSS = `
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; }

.clasificacion-pagina { display: grid; grid-template-columns: 1fr 280px; gap: 1.25rem; align-items: start; }
@media(max-width:960px){ .clasificacion-pagina { grid-template-columns: 1fr; } .clasificacion-barra-lateral { order: -1; } }

.clasificacion-heroe { background: linear-gradient(135deg, #1e1b4b, #3730a3, #4f46e5); border-radius: 16px; padding: 1.75rem; margin-bottom: 1.25rem; }
.heroe-superior { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
.heroe-titulo { font-family: 'DM Serif Display', serif; font-size: 22px; color: #fff; margin-bottom: 4px; }
.heroe-subtitulo { font-size: 13px; color: rgba(255,255,255,0.6); font-weight: 300; }

.pestanas-periodo { display: flex; gap: 6px; flex-wrap: wrap; }
.pestana-periodo { padding: 6px 16px; border-radius: 20px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.7); cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif; }
.pestana-periodo:hover { background: rgba(255,255,255,0.15); color: #fff; }
.pestana-periodo.activa { background: #fff; color: #3730a3; border-color: #fff; }

.podio-contenedor { display: flex; align-items: flex-end; justify-content: center; gap: 12px; margin-bottom: 1.5rem; }
.podio-columna { display: flex; flex-direction: column; align-items: center; gap: 8px; width: 110px; }
.podio-avatar { border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; color: #fff; border: 3px solid; flex-shrink: 0; }
.podio-nombre { font-size: 12px; font-weight: 600; color: #1e1b4b; text-align: center; line-height: 1.3; max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.podio-puntos { font-size: 13px; font-weight: 700; color: #3730a3; }
.podio-base { border-radius: 10px 10px 0 0; width: 100%; display: flex; align-items: center; justify-content: center; font-size: 22px; }

.tabla-clasificacion { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; overflow: hidden; }
.tabla-cabecera { display: grid; grid-template-columns: 50px 1fr 120px 90px; padding: 10px 16px; background: #f9faf8; border-bottom: 1px solid #e8ebe6; font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; }
.tabla-fila { display: grid; grid-template-columns: 50px 1fr 120px 90px; padding: 12px 16px; border-bottom: 1px solid #f5f5f3; align-items: center; transition: background 0.1s; }
.tabla-fila:last-child { border-bottom: none; }
.tabla-fila:hover { background: #fafaf9; }
.tabla-fila.yo { background: #f0f9ff; border-left: 3px solid #3730a3; }
.fila-posicion { font-size: 15px; font-weight: 700; color: #6b7c6d; text-align: center; }
.fila-usuario { display: flex; align-items: center; gap: 10px; }
.fila-avatar { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #fff; background: #3730a3; flex-shrink: 0; }
.fila-nombre { font-size: 14px; font-weight: 600; color: #1e1b4b; }
.fila-nivel { display: inline-flex; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 500; }
.fila-puntos { font-size: 14px; font-weight: 700; color: #3730a3; text-align: right; }
.fila-puntos-sub { font-size: 11px; color: #9ca3af; font-weight: 400; }
.etiqueta-tu { font-size: 10px; font-weight: 700; background: #3730a3; color: #fff; padding: 1px 6px; border-radius: 20px; margin-left: 6px; }

.barra-lateral-caja { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; padding: 1.1rem 1.25rem; }
.barra-lateral-caja + .barra-lateral-caja { margin-top: 1rem; }
.barra-lateral-titulo { font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 10px; }

.tarjeta-posicion { background: linear-gradient(135deg, #1e1b4b, #3730a3); border-radius: 12px; padding: 1.25rem; text-align: center; }
.tarjeta-posicion-numero { font-family: 'DM Serif Display', serif; font-size: 48px; color: #fff; line-height: 1; margin-bottom: 4px; }
.tarjeta-posicion-etiqueta { font-size: 12px; color: rgba(255,255,255,0.6); margin-bottom: 10px; }
.tarjeta-posicion-puntos { font-size: 18px; font-weight: 700; color: #a5b4fc; }

.historial-fila { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid #f5f5f3; font-size: 13px; }
.historial-fila:last-child { border-bottom: none; }
.historial-puntos { font-weight: 700; color: #3730a3; }
.historial-posicion { font-size: 11px; color: #9ca3af; }

.estado-vacio { padding: 2.5rem; text-align: center; }

@keyframes flotar { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
`;

export default function ClasificacionIndex({
    ranking, podium, restRanking,
    userPosition, userInRanking, userHistory,
    currentPeriod, periods, currentUser,
}: Props) {

    const cambiarPeriodo = (p: string) =>
        router.get(route('leaderboard.index'), { period: p }, { preserveScroll: true });

    const periodoActual = periods.find(p => p.value === currentPeriod);

    const podioOrdenado = [podium[1], podium[0], podium[2]].filter(Boolean);

    return (
        <AppLayout header={
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <div>
                    <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 21, color: '#1e1b4b', margin: 0 }}>
                        Clasificacion
                    </h1>
                    <p style={{ fontSize: 13, color: '#6b7c6d', margin: '3px 0 0', fontWeight: 300 }}>
                        {periodoActual?.label} · Posicion {userPosition}
                    </p>
                </div>
            </div>
        }>
            <Head title="Clasificacion" />
            <style>{CSS}</style>

            <div className="clasificacion-heroe">
                <div className="heroe-superior">
                    <div>
                        <div className="heroe-titulo">Clasificacion global</div>
                        <div className="heroe-subtitulo">
                            {ranking.length} recicladores compitiendo · Tu posicion: {userPosition}
                        </div>
                    </div>
                </div>
                <div className="pestanas-periodo">
                    {periods.map(p => (
                        <button
                            key={p.value}
                            className={`pestana-periodo${currentPeriod === p.value ? ' activa' : ''}`}
                            onClick={() => cambiarPeriodo(p.value)}
                        >
                            {p.label}
                        </button>
                    ))}
                </div>
            </div>

            <div className="clasificacion-pagina">
                <div>
                    {podium.length >= 1 && (
                        <div style={{ background: '#fff', borderRadius: 14, border: '1px solid #e8ebe6', padding: '1.5rem 1rem', marginBottom: '1.25rem' }}>
                            <div style={{ fontSize: 13, fontWeight: 600, color: '#9ca3af', textTransform: 'uppercase', letterSpacing: '0.4px', textAlign: 'center', marginBottom: '1.25rem' }}>
                                Podio
                            </div>
                            <div className="podio-contenedor">
                                {podioOrdenado.map((entrada) => {
                                    if (!entrada) return null;
                                    const pos  = entrada.position as 1 | 2 | 3;
                                    const tam  = TAMANIO_PODIO[pos];
                                    const soYo = entrada.id === currentUser.id;
                                    const cn   = COLORES_NIVEL[entrada.level] ?? COLORES_NIVEL.BEGINNER;
                                    return (
                                        <div key={entrada.id} className="podio-columna" style={{ marginTop: tam.margenSuperior }}>
                                            <div style={{ fontSize: 24 }}>{MEDALLA[pos]}</div>
                                            <div
                                                className="podio-avatar"
                                                style={{
                                                    width: 48, height: 48,
                                                    background: cn.texto,
                                                    borderColor: tam.anillo,
                                                    boxShadow: soYo ? `0 0 0 3px ${tam.anillo}` : 'none',
                                                }}
                                            >
                                                {entrada.name.charAt(0).toUpperCase()}
                                            </div>
                                            <div className="podio-nombre">
                                                {entrada.name}
                                                {soYo && <span className="etiqueta-tu">tu</span>}
                                            </div>
                                            <div className="podio-puntos">{entrada.score.toLocaleString()} pts</div>
                                            <div
                                                className="podio-base"
                                                style={{ height: tam.alto, background: `${tam.anillo}22`, border: `2px solid ${tam.anillo}44` }}
                                            >
                                                {pos}
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    )}

                    {restRanking.length > 0 && (
                        <div className="tabla-clasificacion">
                            <div className="tabla-cabecera">
                                <span style={{ textAlign: 'center' }}>Pos</span>
                                <span>Usuario</span>
                                <span>Nivel</span>
                                <span style={{ textAlign: 'right' }}>Puntos</span>
                            </div>
                            {restRanking.map(entrada => {
                                const soYo = entrada.id === currentUser.id;
                                const cn   = COLORES_NIVEL[entrada.level] ?? COLORES_NIVEL.BEGINNER;
                                return (
                                    <div key={entrada.id} className={`tabla-fila${soYo ? ' yo' : ''}`}>
                                        <div className="fila-posicion">{entrada.position}</div>
                                        <div className="fila-usuario">
                                            <div className="fila-avatar" style={{ background: cn.texto }}>
                                                {entrada.name.charAt(0).toUpperCase()}
                                            </div>
                                            <div>
                                                <div className="fila-nombre">
                                                    {entrada.name}
                                                    {soYo && <span className="etiqueta-tu">tu</span>}
                                                </div>
                                                <div style={{ fontSize: 12, color: '#9ca3af' }}>@{entrada.username}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span className="fila-nivel" style={{ background: cn.fondo, color: cn.texto }}>
                                                {entrada.level.charAt(0) + entrada.level.slice(1).toLowerCase()}
                                            </span>
                                        </div>
                                        <div className="fila-puntos">
                                            {entrada.score.toLocaleString()}
                                            <div className="fila-puntos-sub">pts</div>
                                        </div>
                                    </div>
                                );
                            })}

                            {!userInRanking && userPosition > 50 && (
                                <>
                                    <div style={{ padding: '8px 16px', textAlign: 'center', fontSize: 12, color: '#9ca3af', borderTop: '1px dashed #e8ebe6' }}>
                                        . . .
                                    </div>
                                    <div className="tabla-fila yo">
                                        <div className="fila-posicion">{userPosition}</div>
                                        <div className="fila-usuario">
                                            <div className="fila-avatar" style={{ background: COLORES_NIVEL[currentUser.level]?.texto ?? '#3730a3' }}>
                                                {currentUser.name.charAt(0).toUpperCase()}
                                            </div>
                                            <div>
                                                <div className="fila-nombre">
                                                    {currentUser.name}
                                                    <span className="etiqueta-tu">tu</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <span className="fila-nivel" style={{ background: COLORES_NIVEL[currentUser.level]?.fondo, color: COLORES_NIVEL[currentUser.level]?.texto }}>
                                                {currentUser.level.charAt(0) + currentUser.level.slice(1).toLowerCase()}
                                            </span>
                                        </div>
                                        <div className="fila-puntos">
                                            {currentUser.total_points.toLocaleString()}
                                            <div className="fila-puntos-sub">pts</div>
                                        </div>
                                    </div>
                                </>
                            )}
                        </div>
                    )}

                    {ranking.length === 0 && (
                        <div className="tabla-clasificacion">
                            <div className="estado-vacio">
                                <p style={{ color: '#9ca3af', fontSize: 14, margin: '0 0 14px' }}>
                                    Sin datos para este periodo. 
                                </p>
                                <Link href={route('recycle.index')} style={{ display: 'inline-flex', alignItems: 'center', gap: 6, height: 38, padding: '0 18px', background: '#3730a3', color: '#fff', borderRadius: 8, fontSize: 13, fontWeight: 500, textDecoration: 'none' }}>
                                    Reciclar ahora
                                </Link>
                            </div>
                        </div>
                    )}
                </div>

                <div className="clasificacion-barra-lateral">
                    <div className="barra-lateral-caja">
                        <div className="barra-lateral-titulo">Mi posicion</div>
                        <div className="tarjeta-posicion">
                            <div className="tarjeta-posicion-numero">
                                {userPosition <= 3 ? MEDALLA[userPosition as 1|2|3] : `${userPosition}`}
                            </div>
                            <div className="tarjeta-posicion-etiqueta">{periodoActual?.label}</div>
                            <div className="tarjeta-posicion-puntos">
                                {(userInRanking?.score ?? currentUser.total_points).toLocaleString()} pts
                            </div>
                        </div>
                    </div>

                    {userHistory.length > 0 && (
                        <div className="barra-lateral-caja">
                            <div className="barra-lateral-titulo">Mi historial</div>
                            {userHistory.map((h, i) => (
                                <div key={i} className="historial-fila">
                                    <span style={{ color: '#6b7c6d', fontWeight: 500 }}>{h.period_key}</span>
                                    <div style={{ textAlign: 'right' }}>
                                        <div className="historial-puntos">{h.points.toLocaleString()} pts</div>
                                        <div className="historial-posicion">{h.position}</div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}

                    <div className="barra-lateral-caja">
                        <div className="barra-lateral-titulo">En la clasificacion</div>
                        {[
                            { etiqueta: 'Total participantes', valor: ranking.length },
                            { etiqueta: 'Tu posicion',         valor: userPosition },
                            { etiqueta: 'Periodo',             valor: periodoActual?.label ?? '' },
                        ].map((s, i) => (
                            <div key={i} style={{ display: 'flex', justifyContent: 'space-between', padding: '7px 0', borderBottom: i < 2 ? '1px solid #f5f5f3' : 'none', fontSize: 13 }}>
                                <span style={{ color: '#6b7c6d' }}>{s.etiqueta}</span>
                                <span style={{ fontWeight: 700, color: '#1e1b4b' }}>{s.valor}</span>
                            </div>
                        ))}
                    </div>


                </div>
            </div>
        </AppLayout>
    );
}