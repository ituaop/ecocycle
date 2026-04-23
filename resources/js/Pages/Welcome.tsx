import { PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';

export default function Welcome({ auth }: PageProps<{ laravelVersion: string; phpVersion: string }>) {
    return (
        <>
            <Head title="Bienvenido a Ecocycle" />

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap');
                * { box-sizing: border-box; margin: 0; padding: 0; }
                body { font-family: 'DM Sans', sans-serif; background: #1a3a2a; min-height: 100vh; }
                .hero-nav { position: fixed; top: 0; left: 0; right: 0; z-index: 50; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; background: rgba(26,58,42,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(82,183,136,0.1); }
                .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
                .brand-icon { width: 36px; height: 36px; background: #52b788; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
                .brand-name { font-family: 'DM Serif Display', serif; font-size: 22px; color: #fff; }
                .nav-actions { display: flex; align-items: center; gap: 12px; }
                .btn-ghost { padding: 8px 18px; border-radius: 8px; font-size: 14px; color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 400; transition: color 0.15s; }
                .btn-ghost:hover { color: #fff; }
                .btn-solid { padding: 9px 20px; border-radius: 8px; font-size: 14px; background: #52b788; color: #1a3a2a; font-weight: 500; text-decoration: none; transition: background 0.15s; }
                .btn-solid:hover { background: #6dd4a4; }
                .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 6rem 2rem 4rem; position: relative; overflow: hidden; }
                .hero-bg { position: absolute; inset: 0; }
                .hero-content { position: relative; z-index: 2; text-align: center; max-width: 700px; }
                .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(82,183,136,0.15); border: 1px solid rgba(82,183,136,0.3); padding: 6px 16px; border-radius: 20px; font-size: 13px; color: #52b788; margin-bottom: 2rem; }
                .hero-title { font-family: 'DM Serif Display', serif; font-size: clamp(40px, 7vw, 72px); color: #fff; line-height: 1.05; letter-spacing: -2px; margin-bottom: 1.5rem; }
                .hero-title em { color: #52b788; font-style: italic; }
                .hero-desc { font-size: 18px; color: rgba(255,255,255,0.6); line-height: 1.7; font-weight: 300; max-width: 520px; margin: 0 auto 2.5rem; }
                .hero-cta { display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap; }
                .btn-cta { display: flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 12px; font-size: 16px; font-weight: 500; font-family: 'DM Sans', sans-serif; text-decoration: none; transition: transform 0.15s, background 0.15s; }
                .btn-cta:hover { transform: translateY(-2px); }
                .btn-cta.primary { background: #52b788; color: #1a3a2a; }
                .btn-cta.primary:hover { background: #6dd4a4; }
                .btn-cta.secondary { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.15); }
                .btn-cta.secondary:hover { background: rgba(255,255,255,0.15); }
                .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; max-width: 900px; margin: 4rem auto 0; }
                @media(max-width: 700px) { .features { grid-template-columns: 1fr; } }
                .feature-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(82,183,136,0.15); border-radius: 14px; padding: 1.5rem; text-align: left; }
                .feature-icon { width: 44px; height: 44px; background: rgba(82,183,136,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
                .feature-title { font-size: 16px; font-weight: 500; color: #fff; margin-bottom: 0.5rem; }
                .feature-desc { font-size: 14px; color: rgba(255,255,255,0.5); line-height: 1.6; font-weight: 300; }
            `}</style>

            <nav className="hero-nav">
                <div className="nav-brand">
                    <div className="brand-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a3a2a" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 7.19 7 5c-.29 2.19-1.14 3.31-2.29 4.06C3.57 9.99 3 11.09 3 12.25 3 14.47 4.8 16.3 7 16.3z" />
                            <path d="M12.56 6.6A10.97 10.97 0 0014 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 01-11.91 4.97" />
                        </svg>
                    </div>
                    <span className="brand-name">Ecocycle</span>
                </div>
                <div className="nav-actions">
                    {auth.user ? (
                        <Link href={route('dashboard')} className="btn-solid">Ir al dashboard</Link>
                    ) : (
                        <>
                            <Link href={route('login')} className="btn-ghost">Iniciar sesión</Link>
                            <Link href={route('register')} className="btn-solid">Registrarse gratis</Link>
                        </>
                    )}
                </div>
            </nav>

            <section className="hero">
                <svg className="hero-bg" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="200" cy="150" rx="400" ry="300" fill="rgba(82,183,136,0.06)" transform="rotate(-15 200 150)" />
                    <ellipse cx="1000" cy="650" rx="500" ry="350" fill="rgba(82,183,136,0.05)" transform="rotate(10 1000 650)" />
                    <circle cx="600" cy="400" r="250" fill="rgba(82,183,136,0.03)" />
                </svg>

                <div className="hero-content">
                    <div className="hero-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
                        Plataforma de reciclaje con recompensas
                    </div>

                    <h1 className="hero-title">
                        Recicla mejor.<br />
                        Vive <em>más verde.</em>
                    </h1>

                    <p className="hero-desc">
                        Registra tus acciones de reciclaje, acumula puntos y sube de nivel.
                        Conectamos ciudadanos comprometidos con puntos de recogida locales.
                    </p>

                    <div className="hero-cta">
                        <Link href={route('register')} className="btn-cta primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><circle cx="8.5" cy="7" r="4" /><line x1="20" y1="8" x2="20" y2="14" /><line x1="23" y1="11" x2="17" y2="11" />
                            </svg>
                            Empezar gratis
                        </Link>
                        <Link href={route('login')} className="btn-cta secondary">
                            Ya tengo cuenta
                        </Link>
                    </div>

                    <div className="features">
                        {[
                            { icon: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', title: 'Gana puntos', desc: 'Cada reciclaje suma puntos. Sube de nivel y desbloquea recompensas.' },
                            { icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', title: 'Puntos de recogida', desc: 'Más de 847 puntos activos en toda la ciudad. Siempre hay uno cerca.' },
                            { icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', title: 'Sigue tu impacto', desc: 'Visualiza cuánto has reciclado y el impacto real en el planeta.' },
                        ].map((f, i) => (
                            <div className="feature-card" key={i}>
                                <div className="feature-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#52b788" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <path d={f.icon} />
                                    </svg>
                                </div>
                                <div className="feature-title">{f.title}</div>
                                <div className="feature-desc">{f.desc}</div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </>
    );
}
