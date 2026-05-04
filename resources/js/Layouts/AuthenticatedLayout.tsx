import { Link, usePage } from '@inertiajs/react';
import { PropsWithChildren, ReactNode, useState } from 'react';

export default function AuthenticatedLayout({
    header,
    children,
}: PropsWithChildren<{ header?: ReactNode }>) {
    const user = usePage().props.auth.user;
    const [mobileOpen, setMobileOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);

    const navLinks = [
        { href: route('dashboard'), label: 'Dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
        { href: '#', label: 'Acciones', icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15' },
        { href: '#', label: 'Puntos de recogida', icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z' },
        { href: '#', label: 'Residuos', icon: 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' },
    ];

    const currentPath = window.location.pathname;

    return (
        <>
            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap');
                :root { --green-dark:#1a3a2a; --green-mid:#2d6a4f; --green-light:#52b788; --green-pale:#d8f3dc; --cream:#f8f5f0; }
                body { font-family:'DM Sans',sans-serif; background:#f4f6f3; margin:0; }
                .app-nav {
                    background: var(--green-dark);
                    position: sticky; top: 0; z-index: 50;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
                }
                .nav-inner { max-width:1280px; margin:0 auto; padding:0 1.5rem; display:flex; align-items:center; height:64px; gap:2rem; }
                .nav-brand { display:flex; align-items:center; gap:10px; text-decoration:none; flex-shrink:0; }
                .nav-brand-icon { width:32px; height:32px; background:var(--green-light); border-radius:50%; display:flex; align-items:center; justify-content:center; }
                .nav-brand-name { font-family:'DM Serif Display',serif; font-size:20px; color:#fff; }
                .nav-links { display:flex; align-items:center; gap:0.25rem; flex:1; }
                @media(max-width:768px) { .nav-links { display:none; } }
                .nav-link { display:flex; align-items:center; gap:7px; padding:0.5rem 0.9rem; border-radius:8px; font-size:14px; color:rgba(255,255,255,0.65); text-decoration:none; transition:background 0.15s, color 0.15s; white-space:nowrap; }
                .nav-link:hover { background:rgba(255,255,255,0.08); color:#fff; }
                .nav-link.active { background:rgba(82,183,136,0.2); color:#fff; }
                .nav-link svg { flex-shrink:0; }
                .nav-right { display:flex; align-items:center; gap:1rem; margin-left:auto; }
                .points-pill { display:flex; align-items:center; gap:6px; background:rgba(82,183,136,0.15); padding:5px 12px; border-radius:20px; font-size:13px; color:var(--green-light); font-weight:500; }
                .avatar-btn { display:flex; align-items:center; gap:8px; background:none; border:none; cursor:pointer; padding:4px; border-radius:8px; transition:background 0.15s; position:relative; }
                .avatar-btn:hover { background:rgba(255,255,255,0.08); }
                .avatar { width:34px; height:34px; border-radius:50%; background:var(--green-light); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:500; color:var(--green-dark); }
                .avatar-name { font-size:14px; color:rgba(255,255,255,0.8); }
                @media(max-width:768px) { .avatar-name { display:none; } }
                .dropdown-menu { position:absolute; top:calc(100% + 8px); right:0; background:#fff; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); min-width:180px; overflow:hidden; border:1px solid #e8e8e8; }
                .dropdown-item { display:flex; align-items:center; gap:8px; padding:10px 14px; font-size:14px; color:#374151; text-decoration:none; transition:background 0.15s; cursor:pointer; background:none; border:none; width:100%; text-align:left; font-family:inherit; }
                .dropdown-item:hover { background:#f9fafb; }
                .dropdown-divider { height:1px; background:#f0f0f0; margin:4px 0; }
                .dropdown-item.danger { color:#dc2626; }
                .mobile-menu-btn { display:none; background:none; border:none; cursor:pointer; padding:6px; border-radius:6px; color:rgba(255,255,255,0.8); }
                @media(max-width:768px) { .mobile-menu-btn { display:flex; align-items:center; justify-content:center; } }
                .mobile-menu { background:var(--green-dark); border-top:1px solid rgba(255,255,255,0.1); padding:0.75rem 1rem; }
                .mobile-link { display:flex; align-items:center; gap:8px; padding:0.65rem 0.75rem; border-radius:8px; font-size:14px; color:rgba(255,255,255,0.7); text-decoration:none; transition:background 0.15s; }
                .mobile-link:hover, .mobile-link.active { background:rgba(255,255,255,0.08); color:#fff; }
                .page-header { background:#fff; border-bottom:1px solid #eaece8; }
                .page-header-inner { max-width:1280px; margin:0 auto; padding:1.25rem 1.5rem; }
                .page-main { max-width:1280px; margin:0 auto; padding:2rem 1.5rem; }
            `}</style>

            <div className="app-nav">
                <div className="nav-inner">
                    <Link href={route('dashboard')} className="nav-brand">
                        <div className="nav-brand-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a3a2a" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 7.19 7 5c-.29 2.19-1.14 3.31-2.29 4.06C3.57 9.99 3 11.09 3 12.25 3 14.47 4.8 16.3 7 16.3z" />
                                <path d="M12.56 6.6A10.97 10.97 0 0014 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 01-11.91 4.97" />
                            </svg>
                        </div>
                        <span className="nav-brand-name">Ecocycle</span>
                    </Link>

                    <nav className="nav-links">
                        {navLinks.map(link => (
                            <Link
                                key={link.label}
                                href={link.href}
                                className={`nav-link${currentPath === new URL(link.href, window.location.origin).pathname ? ' active' : ''}`}
                            >
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                    <path d={link.icon} />
                                </svg>
                                {link.label}
                            </Link>
                        ))}
                    </nav>

                    <div className="nav-right">
                        <div className="points-pill">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            {user.total_points ?? 0} pts
                        </div>

                        <div style={{ position: 'relative' }}>
                            <button className="avatar-btn" onClick={() => setProfileOpen(v => !v)}>
                                <div className="avatar">{user.name.charAt(0).toUpperCase()}</div>
                                <span className="avatar-name">{user.name}</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            {profileOpen && (
                                <>
                                    <div style={{ position: 'fixed', inset: 0, zIndex: 40 }} onClick={() => setProfileOpen(false)} />
                                    <div className="dropdown-menu" style={{ zIndex: 50 }}>
                                        <div style={{ padding: '10px 14px 6px', fontSize: '12px', color: '#9ca3af', fontWeight: 500, textTransform: 'uppercase', letterSpacing: '0.5px' }}>
                                            {user.email}
                                        </div>
                                        <div className="dropdown-divider" />
                                        <Link href={route('profile.edit')} className="dropdown-item" onClick={() => setProfileOpen(false)}>
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" /><circle cx="12" cy="7" r="4" />
                                            </svg>
                                            Mi perfil
                                        </Link>
                                        <div className="dropdown-divider" />
                                        <Link href={route('logout')} method="post" as="button" className="dropdown-item danger" onClick={() => setProfileOpen(false)}>
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" />
                                            </svg>
                                            Cerrar sesión
                                        </Link>
                                    </div>
                                </>
                            )}
                        </div>

                        <button className="mobile-menu-btn" onClick={() => setMobileOpen(v => !v)}>
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                {mobileOpen ? <><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></> : <><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="18" x2="21" y2="18" /></>}
                            </svg>
                        </button>
                    </div>
                </div>

                {mobileOpen && (
                    <div className="mobile-menu">
                        {navLinks.map(link => (
                            <Link key={link.label} href={link.href} className="mobile-link" onClick={() => setMobileOpen(false)}>
                                {link.label}
                            </Link>
                        ))}
                    </div>
                )}
            </div>

            {header && (
                <div className="page-header">
                    <div className="page-header-inner">{header}</div>
                </div>
            )}

            <main className="page-main">{children}</main>
        </>
    );
}
