import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface ResultadoReciclaje {
    points_earned: number;
    total_points:  number;
    level_before:  string;
    level_after:   string;
    level_up:      boolean;
    waste_name:    string;
    quantity:      number;
}

interface Rango {
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
    result:       ResultadoReciclaje;
    user:         { name: string; total_points: number; level: string };
    allRanks:     Rango[];
    nextRank:     Rango | null;
    progress:     number;
    pointsToNext: number | null;
}

const CSS = `
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; }

.resultado-contenedor { max-width: 520px; margin: 0 auto; }

.banner-subida-nivel { background: linear-gradient(135deg, #7e22ce, #a855f7); border-radius: 16px 16px 0 0; padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 14px; }
.banner-icono { font-size: 42px; flex-shrink: 0; animation: flotar 2s ease infinite; }
.banner-titulo { font-size: 17px; font-weight: 700; color: #fff; }
.banner-subtitulo { font-size: 13px; color: rgba(255,255,255,0.85); margin-top: 3px; }
.banner-descripcion { font-size: 12px; color: rgba(255,255,255,0.65); margin-top: 3px; }

.tarjeta-resultado { background: #fff; border: 1px solid #e8ebe6; overflow: hidden; margin-bottom: 1.25rem; }
.tarjeta-resultado.redondeada { border-radius: 16px; }
.tarjeta-resultado.redondeada-inferior { border-radius: 0 0 16px 16px; }

.heroe-resultado { background: linear-gradient(135deg, #1a3a2a 0%, #2d6a4f 100%); padding: 2.5rem 2rem; text-align: center; position: relative; overflow: hidden; }
.heroe-resultado::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 70% 30%, rgba(82,183,136,0.18) 0%, transparent 60%); }
.heroe-etiqueta { font-size: 18px; position: relative; margin-bottom: 10px; color: rgba(255,255,255,0.65); }
.heroe-puntos { font-family: 'DM Serif Display', serif; font-size: 72px; color: #52b788; line-height: 1; letter-spacing: -3px; position: relative; animation: aparicion 0.5s cubic-bezier(0.34,1.56,0.64,1) forwards; }
.heroe-puntos-label { font-size: 16px; color: rgba(255,255,255,0.65); position: relative; margin-top: 4px; }
.heroe-detalle { font-size: 13px; color: rgba(255,255,255,0.45); position: relative; margin-top: 8px; }

.fila-detalle { display: flex; justify-content: space-between; align-items: center; padding: 13px 1.5rem; border-bottom: 1px solid #f9faf8; font-size: 14px; }
.fila-detalle:last-of-type { border-bottom: none; }
.fila-etiqueta { color: #6b7c6d; }
.fila-valor { font-weight: 600; color: #1a3a2a; }

.seccion-progreso { padding: 1.1rem 1.5rem; border-top: 1px solid #f0f0ee; }
.progreso-etiquetas { display: flex; justify-content: space-between; font-size: 12px; color: #9ca3af; margin-bottom: 6px; }
.progreso-fondo { background: #f0f0ee; border-radius: 99px; height: 10px; overflow: hidden; }
.progreso-relleno { height: 100%; border-radius: 99px; transition: width 0.8s ease; }
.progreso-porcentaje { font-size: 11px; color: #9ca3af; text-align: right; margin-top: 4px; }

.botones-accion { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.boton-accion { display: flex; align-items: center; justify-content: center; gap: 7px; height: 50px; border-radius: 12px; font-size: 14px; font-weight: 500; font-family: 'DM Sans', sans-serif; text-decoration: none; transition: transform 0.15s, opacity 0.15s; cursor: pointer; border: none; }
.boton-accion:hover { transform: translateY(-2px); opacity: 0.9; }
.boton-principal { background: #1a3a2a; color: #fff; }
.boton-secundario { background: #f0fdf4; color: #2d6a4f; border: 1.5px solid #bbf7d0; }

@keyframes aparicion { 0%{transform:scale(0.5);opacity:0} 70%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }
@keyframes flotar { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
`;

export default function ResultadoReciclaje({ auth, result, allRanks, nextRank, progress, pointsToNext }: Props) {
    const usuario     = auth.user;
    const rangoActual = allRanks.find(r => r.name === usuario.level);
    const rangoSubida = result.level_up ? allRanks.find(r => r.name === result.level_after) : null;

    return (
        <AppLayout>
            <Head title="Reciclaje registrado" />
            <style>{CSS}</style>

            <div className="resultado-contenedor">

                {result.level_up && rangoSubida && (
                    <div className="banner-subida-nivel">
                        <span className="banner-icono">{rangoSubida.badge_icon}</span>
                        <div>
                            <div className="banner-titulo">Subiste de rango</div>
                            <div className="banner-subtitulo">
                                {allRanks.find(r => r.name === result.level_before)?.label ?? result.level_before}
                                {' hacia '}
                                <strong>{rangoSubida.label}</strong>
                            </div>
                            <div className="banner-descripcion">{rangoSubida.description}</div>
                        </div>
                    </div>
                )}

                <div className={`tarjeta-resultado ${result.level_up ? 'redondeada-inferior' : 'redondeada'}`}>
                    <div className="heroe-resultado">
                        <div className="heroe-etiqueta">Reciclaje registrado</div>
                        <div className="heroe-puntos">+{result.points_earned}</div>
                        <div className="heroe-puntos-label">puntos ganados</div>
                        <div className="heroe-detalle">
                            {result.quantity} x {result.waste_name}
                        </div>
                    </div>

                    <div className="fila-detalle">
                        <span className="fila-etiqueta">Puntos totales</span>
                        <span className="fila-valor" style={{ color: '#2d6a4f', fontSize: 17 }}>
                            {(usuario.total_points ?? 0).toLocaleString()} pts
                        </span>
                    </div>
                    <div className="fila-detalle">
                        <span className="fila-etiqueta">Rango actual</span>
                        <span className="fila-valor" style={{ color: rangoActual?.badge_color }}>
                            {rangoActual?.badge_icon} {rangoActual?.label}
                        </span>
                    </div>

                    <div className="seccion-progreso">
                        <div className="progreso-etiquetas">
                            <span>{rangoActual?.label}</span>
                            {nextRank
                                ? <span>{nextRank.label} en {pointsToNext} pts</span>
                                : <span>Rango maximo alcanzado</span>
                            }
                        </div>
                        <div className="progreso-fondo">
                            <div
                                className="progreso-relleno"
                                style={{ width: `${progress}%`, background: rangoActual?.badge_color ?? '#52b788' }}
                            />
                        </div>
                        <div className="progreso-porcentaje">{progress}% completado</div>
                    </div>
                </div>

                <div className="botones-accion">
                    <Link href={route('recycle.index')} className="boton-accion boton-principal">
                        Reciclar mas
                    </Link>
                    <Link href={route('dashboard')} className="boton-accion boton-secundario">
                        Ver panel principal
                    </Link>
                </div>

            </div>
        </AppLayout>
    );
}