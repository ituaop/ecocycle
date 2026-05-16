import { Head, Link } from '@inertiajs/react';
import { PageProps } from '@/types';

const CSS = `
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'DM Sans', sans-serif; background: #1a3a2a; min-height: 100vh; color: #fff; }

.navegacion { position: fixed; top: 0; left: 0; right: 0; z-index: 50; padding: 1.1rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(26,58,42,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(82,183,136,0.1); }
.marca { display: flex; align-items: center; gap: 9px; text-decoration: none; }
.marca-circulo { width: 34px; height: 34px; background: #52b788; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.marca-nombre { font-family: 'DM Serif Display', serif; font-size: 20px; color: #fff; }
.navegacion-botones { display: flex; align-items: center; gap: 10px; }
.boton-transparente { padding: 7px 16px; border-radius: 8px; font-size: 14px; color: rgba(255,255,255,0.75); text-decoration: none; transition: color .15s; }
.boton-transparente:hover { color: #fff; }
.boton-solido { padding: 8px 18px; border-radius: 8px; font-size: 14px; background: #52b788; color: #1a3a2a; font-weight: 600; text-decoration: none; transition: background .15s; }
.boton-solido:hover { background: #6dd4a4; }

.seccion-principal { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 6rem 2rem 4rem; position: relative; overflow: hidden; }
.contenido-principal { position: relative; z-index: 2; text-align: center; max-width: 680px; }
.etiqueta-principal { display: inline-flex; align-items: center; gap: 7px; background: rgba(82,183,136,0.12); border: 1px solid rgba(82,183,136,0.25); padding: 5px 14px; border-radius: 20px; font-size: 13px; color: #52b788; margin-bottom: 1.75rem; }
.titulo-principal { font-family: 'DM Serif Display', serif; font-size: clamp(38px,7vw,70px); color: #fff; line-height: 1.05; letter-spacing: -2px; margin-bottom: 1.25rem; }
.titulo-principal em { color: #52b788; font-style: italic; }
.descripcion-principal { font-size: 17px; color: rgba(255,255,255,0.55); line-height: 1.7; font-weight: 300; max-width: 500px; margin: 0 auto 2.5rem; }
.botones-llamada { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; }
.boton-llamada-principal { display: flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 12px; background: #52b788; color: #1a3a2a; font-size: 16px; font-weight: 600; text-decoration: none; transition: all .15s; }
.boton-llamada-principal:hover { background: #6dd4a4; transform: translateY(-2px); }
.boton-llamada-secundario { padding: 13px 24px; border-radius: 12px; background: rgba(255,255,255,0.08); color: #fff; font-size: 15px; font-weight: 400; text-decoration: none; border: 1px solid rgba(255,255,255,0.12); transition: all .15s; }
.boton-llamada-secundario:hover { background: rgba(255,255,255,0.14); }

.seccion-como-funciona { background: #f8f5f0; padding: 5rem 2rem; text-align: center; }
.etiqueta-seccion { display: inline-flex; align-items: center; gap: 6px; background: #d8f3dc; color: #2d6a4f; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; margin-bottom: 1rem; letter-spacing: 0.3px; text-transform: uppercase; }
.titulo-seccion { font-family: 'DM Serif Display', serif; font-size: clamp(28px,4vw,42px); color: #1a3a2a; letter-spacing: -1px; margin-bottom: 0.75rem; }
.subtitulo-seccion { font-size: 15px; color: #6b7c6d; font-weight: 300; max-width: 500px; margin: 0 auto 3rem; }
.cuadricula-pasos { display: grid; grid-template-columns: repeat(auto-fit,minmax(220px,1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto; }
.tarjeta-paso { background: #fff; border-radius: 16px; padding: 1.75rem; text-align: left; border: 1px solid #e8ebe6; }
.paso-numero { width: 40px; height: 40px; border-radius: 12px; background: #1a3a2a; color: #fff; display: flex; align-items: center; justify-content: center; font-family: 'DM Serif Display', serif; font-size: 20px; margin-bottom: 1rem; }
.paso-titulo { font-size: 16px; font-weight: 600; color: #1a3a2a; margin-bottom: 6px; }
.paso-descripcion { font-size: 14px; color: #6b7c6d; line-height: 1.6; font-weight: 300; }

.pie-pagina { border-top: 1px solid rgba(255,255,255,0.08); padding: 1.5rem 2rem; text-align: center; font-size: 13px; color: rgba(255,255,255,0.3); }
`;

const PASOS = [
    {
        numero: '1',
        titulo: 'Elige que reciclar',
        descripcion: 'Selecciona el material que has reciclado entre 28 tipos disponibles, desde plastico hasta electronicos.',
    },
    {
        numero: '2',
        titulo: 'Indica donde',
        descripcion: 'Elige el punto de recogida donde lo has depositado. Hay 12 puntos activos en Valencia.',
    },
    {
        numero: '3',
        titulo: 'Gana puntos',
        descripcion: 'Confirma la cantidad y acumula puntos automaticamente. Si alcanzas el umbral, subiras de rango.',
    },
];

export default function PaginaBienvenida({ auth }: PageProps) {
    return (
        <>
            <Head title="Ecocycle — Recicla y gana puntos" />
            <style>{CSS}</style>

            <nav className="navegacion">
                <div className="marca">
                    <div className="marca-circulo">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1a3a2a" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 7.19 7 5c-.29 2.19-1.14 3.31-2.29 4.06C3.57 9.99 3 11.09 3 12.25 3 14.47 4.8 16.3 7 16.3z"/>
                            <path d="M12.56 6.6A10.97 10.97 0 0014 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 01-11.91 4.97"/>
                        </svg>
                    </div>
                    <span className="marca-nombre">Ecocycle</span>
                </div>
                <div className="navegacion-botones">
                    {auth.user ? (
                        <Link href={route('dashboard')} className="boton-solido">Ir al panel principal</Link>
                    ) : (
                        <>
                            <Link href={route('login')}    className="boton-transparente">Iniciar sesion</Link>
                            <Link href={route('register')} className="boton-solido">Empieza gratis</Link>
                        </>
                    )}
                </div>
            </nav>

            <section className="seccion-principal">
                <svg style={{ position:'absolute', inset:0, pointerEvents:'none', opacity:0.6 }} viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="200"  cy="150" rx="400" ry="300" fill="rgba(82,183,136,0.06)" transform="rotate(-15 200 150)"/>
                    <ellipse cx="1000" cy="650" rx="500" ry="350" fill="rgba(82,183,136,0.05)" transform="rotate(10 1000 650)"/>
                </svg>
                <div className="contenido-principal">
                    <div className="etiqueta-principal">Sistema de reciclaje con recompensas</div>
                    <h1 className="titulo-principal">Recicla mejor.<br/><em>Vive mas verde.</em></h1>
                    <p className="descripcion-principal">
                        Registra tus reciclajes, acumula puntos y sube de rango. Conectamos ciudadanos comprometidos con puntos de recogida locales.
                    </p>
                    <div className="botones-llamada">
                        <Link href={route('register')} className="boton-llamada-principal">Empezar gratis</Link>
                        <Link href={route('login')}    className="boton-llamada-secundario">Ya tengo cuenta</Link>
                    </div>
                </div>
            </section>

            <section className="seccion-como-funciona">
                <div className="etiqueta-seccion">Como funciona</div>
                <h2 className="titulo-seccion">En tres pasos sencillos</h2>
                <p className="subtitulo-seccion">
                    Sin complicaciones. Recicla, acumula puntos y sube de rango automaticamente.
                </p>
                <div className="cuadricula-pasos">
                    {PASOS.map(paso => (
                        <div key={paso.numero} className="tarjeta-paso">
                            <div className="paso-numero">{paso.numero}</div>
                            <div className="paso-titulo">{paso.titulo}</div>
                            <p className="paso-descripcion">{paso.descripcion}</p>
                        </div>
                    ))}
                </div>
            </section>

            <footer className="pie-pagina">
                {new Date().getFullYear()} Ecocycle · Hecho para ayudar al planeta
            </footer>
        </>
    );
}