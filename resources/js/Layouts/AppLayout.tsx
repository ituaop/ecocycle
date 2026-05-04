import { Link, usePage } from '@inertiajs/react';
import { PropsWithChildren, ReactNode, useState } from 'react';

const NAV = [
    { href: 'dashboard',           label: 'Inicio',             icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { href: 'recycle.index',        label: 'Reciclar',           icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15' },
    { href: 'collection-points.index', label: 'Puntos de recogida', icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z' },
    { href: 'profile.show',         label: 'Mi perfil',          icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' },
];

const LEVEL_COLORS: Record<string, string> = {
    BEGINNER: '#6b7c6d', INTERMEDIATE: '#2d6a4f', ADVANCED: '#1d6a8a', EXPERT: '#7e22ce',
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
                .nav { position: sticky; top: 0; z-index: 100; background: #1a3a2a; box-shadow: 0 1px 0 rgba(255,255,255,0.06); }
                .nav-inner { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; height: 60px; display: flex; align-items: center; gap: 1.5rem; }
                .nav-brand { display: flex; align-items: center; gap: 9px; text-decoration: none; flex-shrink: 0; }
                .nav-brand-dot { width: 30px; height: 30px; background: #52b788; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
                .nav-brand-name { font-family: 'DM Serif Display', serif; font-size: 18px; color: #fff; letter-spacing: -0.2px; }
                .nav-links { display: flex; gap: 2px; flex: 1; }
                @media(max-width:700px){ .nav-links { display: none; } }
                .nav-link { display: flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; font-size: 13.5px; color: rgba(255,255,255,0.6); text-decoration: none; transition: all 0.15s; white-space: nowrap; }
                .nav-link:hover { color: #fff; background: rgba(255,255,255,0.07); }
                .nav-link.active { color: #fff; background: rgba(82,183,136,0.18); }
                .nav-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }
                .pts-pill { display: flex; align-items: center; gap: 5px; background: rgba(82,183,136,0.15); border: 1px solid rgba(82,183,136,0.25); padding: 4px 10px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #52b788; }
                .level-pill { display: flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
                .avatar-btn { display: flex; align-items: center; gap: 7px; background: none; border: none; cursor: pointer; padding: 4px 8px; border-radius: 8px; transition: background 0.15s; position: relative; }
                .avatar-btn:hover { background: rgba(255,255,255,0.07); }
                .avatar { width: 32px; height: 32px; border-radius: 50%; background: #52b788; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #1a3a2a; }
                .avatar-name { font-size: 13px; color: rgba(255,255,255,0.8); }
                @media(max-width:600px){ .avatar-name,.level-pill { display: none; } }
                .dropdown { position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); min-width: 190px; overflow: hidden; border: 1px solid #e8e8e8; z-index: 200; }
                .dropdown-email { padding: 10px 14px 6px; font-size: 11px; color: #9ca3af; font-weight: 500; text-transform: uppercase; letter-spacing: 0.4px; }
                .dropdown-divider { height: 1px; background: #f0f0f0; margin: 4px 0; }
                .dropdown-item { display: flex; align-items: center; gap: 8px; padding: 9px 14px; font-size: 13.5px; color: #374151; text-decoration: none; transition: background 0.15s; background: none; border: none; width: 100%; text-align: left; cursor: pointer; font-family: inherit; }
                .dropdown-item:hover { background: #f9fafb; }
                .dropdown-item.red { color: #dc2626; }
                .mob-btn { display: none; background: none; border: none; cursor: pointer; color: rgba(255,255,255,0.7); padding: 6px; border-radius: 6px; }
                @media(max-width:700px){ .mob-btn { display: flex; } }
                .mob-menu { background: #1a3a2a; border-top: 1px solid rgba(255,255,255,0.08); padding: 0.5rem 1rem; }
                .mob-link { display: block; padding: 10px 12px; font-size: 14px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; transition: all 0.15s; }
                .mob-link:hover, .mob-link.active { color: #fff; background: rgba(255,255,255,0.07); }
                .page-header { background: #fff; border-bottom: 1px solid #e8ebe6; }
                .page-header-inner { max-width: 1280px; margin: 0 auto; padding: 1.1rem 1.5rem; }
                .page-main { max-width: 1280px; margin: 0 auto; padding: 1.75rem 1.5rem; }
                @keyframes spin { to { transform: rotate(360deg); } }
            `}</style>

            <nav className="nav">
                <div className="nav-inner">
                    <Link href={route('dashboard')} className="nav-brand">
                        <div className="nav-brand-dot">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a3a2a" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 7.19 7 5c-.29 2.19-1.14 3.31-2.29 4.06C3.57 9.99 3 11.09 3 12.25 3 14.47 4.8 16.3 7 16.3z"/>
                                <path d="M12.56 6.6A10.97 10.97 0 0014 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 01-11.91 4.97"/>
                            </svg>
                        </div>
                        <span className="nav-brand-name">EcoCycle</span>
                    </Link>

                    <div className="nav-links">
                        {NAV.map(n => (
                            <Link key={n.href} href={route(n.href)} className={`nav-link${currentRoute === n.href ? ' active' : ''}`}>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d={n.icon}/></svg>
                                {n.label}
                            </Link>
                        ))}
                    </div>

                    <div className="nav-right">
                        <div className="pts-pill">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
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
                                    <div className="dropdown">
                                        <div className="dropdown-email">{user.email}</div>
                                        <div className="dropdown-divider"/>
                                        <Link href={route('profile.show')} className="dropdown-item" onClick={() => setDropOpen(false)}>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                            Mi perfil
                                        </Link>
                                        <Link href={route('recycle.index')} className="dropdown-item" onClick={() => setDropOpen(false)}>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Reciclar ahora
                                        </Link>
                                        <div className="dropdown-divider"/>
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
        </>
    );
}
