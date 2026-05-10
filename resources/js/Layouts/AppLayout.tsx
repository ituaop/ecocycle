import { Link, usePage } from '@inertiajs/react';
import { PropsWithChildren, ReactNode, useState } from 'react';

const NAV = [
    { href: 'dashboard',           label: 'Inicio',             icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { href: 'collection-points.index', label: 'Puntos de recogida', icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z' },
    { href: 'profile.show',         label: 'Mi perfil',          icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' },
    { href: 'rewards',              label: 'Recompensas',        icon: 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7' },
];

const LEVEL_COLORS: Record<string, string> = {
    BEGINNER: '#b9e6be', INTERMEDIATE: '#2d6a4f', ADVANCED: '#1d6a8a', EXPERT: '#7e22ce',
};

export default function AppLayout({ children, header }: PropsWithChildren<{ header?: ReactNode }>) {
    const { auth } = usePage().props as any;
    const user = auth.user;
    const [mobileOpen, setMobileOpen] = useState(false);
    const [dropOpen, setDropOpen] = useState(false);
    const currentRoute = route().current() ?? '';
    const lc = LEVEL_COLORS[user.level] ?? '#6b7c6d';

    return (
        <>
            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
                *, *::before, *::after { box-sizing: border-box; }
                body { margin: 0; font-family: 'DM Sans', sans-serif; background: #f2f4f1; min-height: 100vh; }
                .navegador { position: sticky; top: 0; z-index: 100; background: #1a3a2a; box-shadow: 0 1px 0 rgba(255,255,255,0.06); }
                .navegador-inner { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; height: 60px; display: flex; align-items: center; gap: 1.5rem; }
                .navegador-brand { display: flex; align-items: center; gap: 9px; text-decoration: none; flex-shrink: 0; }
                .navegador-brand-dot { width: 30px; height: 30px; background: #52b788; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
                .navegador-brand-name { font-family: 'DM Serif Display', serif; font-size: 18px; color: #fff; letter-spacing: -0.2px; }
                .navegador-links { display: flex; gap: 2px; flex: 1; }
                @media(max-width:700px){ .navegador-links { display: none; } }
                .navegador-link { display: flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; font-size: 13.5px; color: rgba(255,255,255,0.6); text-decoration: none; transition: all 0.15s; white-space: nowrap; }
                .navegador-link:hover { color: #fff; background: rgba(255,255,255,0.07); }
                .navegador-link.active { color: #fff; background: rgba(82,183,136,0.18); }
                .navegador-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }
                .pts-pill { display: flex; align-items: center; gap: 5px; background: rgba(82,183,136,0.15); border: 1px solid rgba(82,183,136,0.25); padding: 4px 10px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #52b788; }
                .level-pill { display: flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
                .avatar-btn { display: flex; align-items: center; gap: 7px; background: none; border: none; cursor: pointer; padding: 4px 8px; border-radius: 8px; transition: background 0.15s; position: relative; }
                .avatar-btn:hover { background: rgba(255,255,255,0.07); }
                .avatar { width: 32px; height: 32px; border-radius: 50%; background: #52b788; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #1a3a2a; }
                .avatar-name { font-size: 13px; color: rgba(255,255,255,0.8); }
                @media(max-width:600px){ .avatar-name,.level-pill { display: none; } }
                .desplazabajo { position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); min-width: 190px; overflow: hidden; border: 1px solid #e8e8e8; z-index: 200; }
                .desplazabajo-email { padding: 10px 14px 6px; font-size: 11px; color: #9ca3af; font-weight: 500; text-transform: uppercase; letter-spacing: 0.4px; }
                .desplazabajo-divider { height: 1px; background: #f0f0f0; margin: 4px 0; }
                .desplazabajo-item { display: flex; align-items: center; gap: 8px; padding: 9px 14px; font-size: 13.5px; color: #374151; text-decoration: none; transition: background 0.15s; background: none; border: none; width: 100%; text-align: left; cursor: pointer; font-family: inherit; }
                .desplazabajo-item:hover { background: #f9fafb; }
                .desplazabajo-item.red { color: #dc2626; }
                .mob-btn { display: none; background: none; border: none; cursor: pointer; color: rgba(255,255,255,0.7); padding: 6px; border-radius: 6px; }
                @media(max-width:700px){ .mob-btn { display: flex; } }
                .mob-menu { background: #1a3a2a; border-top: 1px solid rgba(255,255,255,0.08); padding: 0.5rem 1rem; }
                .mob-link { display: block; padding: 10px 12px; font-size: 14px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; transition: all 0.15s; }
                .mob-link:hover, .mob-link.active { color: #fff; background: rgba(255,255,255,0.07); }
                .page-header { background: #fff; border-bottom: 1px solid #e8ebe6; }
                .page-header-inner { max-width: 1280px; margin: 0 auto; padding: 1.1rem 1.5rem; }
                .page-main { max-width: 1280px; margin: 0 auto; padding: 1.75rem 1.5rem; }
                .footer{border-top:1px solid rgba(255,255,255,0.08);padding:1.5rem 2rem;text-align:center;font-size:13px;color:rgba(255,255,255,0.3);}
                @keyframes spin { to { transform: rotate(360deg); } }
            `}</style>

            <nav className="navegador">
                <div className="navegador-inner">
                    <Link href={route('dashboard')} className="navegador-brand">
                        <div className="navegador-brand-dot">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a3a2a" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                            </svg>
                        </div>
                        <span className="navegador-brand-name">Ecocycle</span>
                    </Link>

                    <div className="navegador-links">
                        {NAV.map(n => (
                            <Link key={n.href} href={route(n.href)} className={`navegador-link${currentRoute === n.href ? ' active' : ''}`}>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d={n.icon}/></svg>
                                {n.label}
                            </Link>
                        ))}
                    </div>

                    <div className="navegador-right">
                        <div className="pts-pill">
                            {(user.total_points ?? 0).toLocaleString()} pts
                        </div>
                        <div className="level-pill" style={{ background: `${lc}22`, color: lc }}>
                            {user.level?.charAt(0) + (user.level ?? '').slice(1).toLowerCase()}
                        </div>

                        <div style={{ position: 'relative' }}>
                            <button className="avatar-btn" onClick={() => setDropOpen(v => !v)}>
                                <div className="avatar">{user.name?.charAt(0).toUpperCase()}</div>
                                <span className="avatar-name">{user.name?.split(' ')[0]}</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                            </button>
                            {dropOpen && (
                                <>
                                    <div style={{ position: 'fixed', inset: 0, zIndex: 99 }} onClick={() => setDropOpen(false)}/>
                                    <div className="desplazabajo">
                                        <div className="desplazabajo-email">{user.email}</div>
                                        <div className="desplazabajo-divider"/>
                                        <Link href={route('profile.show')} className="desplazabajo-item" onClick={() => setDropOpen(false)}>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                            Mi perfil
                                        </Link>
                                        
                                        <div className="desplazabajo-divider"/>
                                        <Link href={route('logout')} method="post" as="button" className="dropdown-item red" onClick={() => setDropOpen(false)}>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                            Cerrar sesión
                                        </Link>
                                    </div>
                                </>
                            )}
                        </div>

                        <button className="mob-btn" onClick={() => setMobileOpen(v => !v)}>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                {mobileOpen ? <><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></> : <><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></>}
                            </svg>
                        </button>
                    </div>
                </div>
                {mobileOpen && (
                    <div className="mob-menu">
                        {NAV.map(n => <Link key={n.href} href={route(n.href)} className={`mob-link${currentRoute === n.href ? ' active' : ''}`} onClick={() => setMobileOpen(false)}>{n.label}</Link>)}
                    </div>
                )}
            </nav>

            {header && <div className="page-header"><div className="page-header-inner">{header}</div></div>}
            <main className="page-main">{children}</main>
            <footer className="footer">
                © {new Date().getFullYear()} Ecocycle · Hecho para ayudar al planeta
            </footer>
        </>
    );
}
