import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

interface LoginProps {
    status?: string;
    canResetPassword: boolean;
}

export default function Login({ status, canResetPassword }: LoginProps) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false as boolean,
    });

    const [showPassword, setShowPassword] = useState(false);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <>
            <Head title="Iniciar sesión" />

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap');
                * { box-sizing: border-box; margin: 0; padding: 0; }
                :root {
                    --green-dark: #1a3a2a;
                    --green-mid: #2d6a4f;
                    --green-light: #52b788;
                    --green-pale: #d8f3dc;
                    --cream: #f8f5f0;
                    --text-dark: #1c1c1c;
                    --text-muted: #6b7c6d;
                }
                html, body { height: 100%; }
                .login-wrap {
                    min-height: 100vh;
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    font-family: 'DM Sans', sans-serif;
                    background: var(--cream);
                }
                @media (max-width: 768px) {
                    .login-wrap { grid-template-columns: 1fr; }
                    .left-panel { display: none; }
                }
                .left-panel {
                    background: var(--green-dark);
                    position: relative;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    padding: 3rem;
                }
                .leaf-bg { position: absolute; inset: 0; pointer-events: none; }
                .brand { position: relative; z-index: 2; display: flex; align-items: center; gap: 10px; }
                .brand-icon {
                    width: 36px; height: 36px;
                    background: var(--green-light);
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                }
                .brand-name {
                    font-family: 'DM Serif Display', serif;
                    font-size: 22px;
                    color: #fff;
                    letter-spacing: -0.3px;
                }
                .tagline-block { position: relative; z-index: 2; }
                .tagline-block h1 {
                    font-family: 'DM Serif Display', serif;
                    font-size: 42px;
                    color: #fff;
                    line-height: 1.15;
                    letter-spacing: -1px;
                    margin-bottom: 1.2rem;
                }
                .tagline-block h1 em { color: var(--green-light); font-style: italic; }
                .tagline-block p {
                    color: rgba(255,255,255,0.6);
                    font-size: 15px;
                    line-height: 1.7;
                    max-width: 300px;
                    font-weight: 300;
                }
                .stats-row { position: relative; z-index: 2; display: flex; gap: 2rem; }
                .stat { border-top: 1px solid rgba(255,255,255,0.15); padding-top: 1rem; }
                .stat-num { font-family: 'DM Serif Display', serif; font-size: 28px; color: var(--green-light); }
                .stat-label { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 2px; font-weight: 300; letter-spacing: 0.5px; text-transform: uppercase; }
                .right-panel {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    padding: 4rem 3.5rem;
                    overflow-y: auto;
                }
                .form-header { margin-bottom: 2.5rem; }
                .form-header h2 {
                    font-family: 'DM Serif Display', serif;
                    font-size: 32px;
                    color: var(--text-dark);
                    letter-spacing: -0.5px;
                    margin-bottom: 0.5rem;
                }
                .form-header p { font-size: 14px; color: var(--text-muted); font-weight: 300; }
                .form-header p a { color: var(--green-mid); font-weight: 500; text-decoration: none; }
                .form-group { margin-bottom: 1.25rem; }
                .form-label {
                    display: block;
                    font-size: 12px;
                    font-weight: 500;
                    color: var(--text-muted);
                    letter-spacing: 0.6px;
                    text-transform: uppercase;
                    margin-bottom: 0.5rem;
                }
                .input-wrap { position: relative; }
                .input-icon {
                    position: absolute;
                    left: 14px; top: 50%; transform: translateY(-50%);
                    color: var(--text-muted);
                    pointer-events: none;
                    display: flex;
                }
                .form-input {
                    width: 100%;
                    height: 50px;
                    padding: 0 16px 0 42px;
                    border: 1.5px solid #ddd;
                    border-radius: 10px;
                    font-size: 15px;
                    font-family: 'DM Sans', sans-serif;
                    color: var(--text-dark);
                    background: #fff;
                    outline: none;
                    transition: border-color 0.2s, box-shadow 0.2s;
                }
                .form-input:focus { border-color: var(--green-mid); box-shadow: 0 0 0 3px rgba(45,106,79,0.08); }
                .form-input::placeholder { color: #bbb; font-weight: 300; }
                .form-input.error { border-color: #e53e3e; }
                .toggle-pass {
                    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
                    background: none; border: none; cursor: pointer;
                    color: var(--text-muted); padding: 0;
                    display: flex; align-items: center;
                }
                .form-footer {
                    display: flex; justify-content: space-between; align-items: center;
                    margin-bottom: 1.5rem;
                }
                .remember { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); cursor: pointer; }
                .remember input { accent-color: var(--green-mid); width:16px; height:16px; }
                .forgot { font-size: 13px; color: var(--green-mid); font-weight: 500; text-decoration: none; background: none; border: none; cursor: pointer; }
                .btn-login {
                    width: 100%; height: 52px;
                    background: var(--green-dark);
                    color: #fff;
                    border: none; border-radius: 10px;
                    font-size: 15px; font-weight: 500;
                    font-family: 'DM Sans', sans-serif;
                    cursor: pointer;
                    display: flex; align-items: center; justify-content: center; gap: 8px;
                    transition: background 0.2s, transform 0.15s;
                    position: relative; overflow: hidden;
                }
                .btn-login:hover:not(:disabled) { background: var(--green-mid); transform: translateY(-1px); }
                .btn-login:active:not(:disabled) { transform: translateY(0); }
                .btn-login:disabled { opacity: 0.6; cursor: not-allowed; }
                .divider { display: flex; align-items: center; gap: 12px; margin: 1.5rem 0; }
                .divider-line { flex: 1; height: 1px; background: #e8e8e8; }
                .divider-text { font-size: 12px; color: #bbb; font-weight: 400; }
                .btn-google {
                    width: 100%; height: 50px;
                    background: #fff;
                    border: 1.5px solid #e0e0e0;
                    border-radius: 10px;
                    font-size: 14px; font-weight: 500; color: var(--text-dark);
                    font-family: 'DM Sans', sans-serif;
                    cursor: pointer;
                    display: flex; align-items: center; justify-content: center; gap: 10px;
                    transition: border-color 0.2s, box-shadow 0.2s;
                }
                .btn-google:hover { border-color: #bbb; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
                .field-error { font-size: 12px; color: #e53e3e; margin-top: 5px; }
                .status-msg {
                    background: #f0fdf4; border: 1px solid #bbf7d0;
                    color: var(--green-mid); font-size: 13px;
                    padding: 10px 14px; border-radius: 8px;
                    margin-bottom: 1rem;
                }
                .points-badge {
                    display: inline-flex; align-items: center; gap: 6px;
                    background: var(--green-pale);
                    color: var(--green-mid);
                    font-size: 12px; font-weight: 500;
                    padding: 5px 12px; border-radius: 20px;
                    margin-bottom: 1.5rem;
                }
            `}</style>

            <div className="login-wrap">
                {/* Left decorative panel */}
                <div className="left-panel">
                    <svg className="leaf-bg" viewBox="0 0 600 800" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="500" cy="100" rx="280" ry="200" fill="rgba(82,183,136,0.07)" transform="rotate(-20 500 100)" />
                        <ellipse cx="-60" cy="700" rx="320" ry="220" fill="rgba(82,183,136,0.06)" transform="rotate(15 -60 700)" />
                        <circle cx="420" cy="650" r="180" fill="rgba(255,255,255,0.02)" />
                        <path d="M80 200 Q160 120 200 200 Q160 280 80 200Z" fill="rgba(82,183,136,0.12)" transform="rotate(-10 140 200)" />
                        <path d="M350 400 Q450 300 480 420 Q420 500 350 400Z" fill="rgba(82,183,136,0.08)" transform="rotate(5 415 400)" />
                    </svg>

                    <div className="brand">
                        <div className="brand-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a3a2a" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 7.19 7 5c-.29 2.19-1.14 3.31-2.29 4.06C3.57 9.99 3 11.09 3 12.25 3 14.47 4.8 16.3 7 16.3z" />
                                <path d="M12.56 6.6A10.97 10.97 0 0014 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 01-11.91 4.97" />
                            </svg>
                        </div>
                        <span className="brand-name">Ecocycle</span>
                    </div>

                    <div className="tagline-block">
                        <h1>Recicla.<br />Gana puntos.<br /><em>Marca la diferencia.</em></h1>
                        <p>Únete a miles de usuarios comprometidos con el medio ambiente. Cada acción de reciclaje suma puntos y contribuye a un planeta más limpio.</p>
                    </div>

                    <div className="stats-row">
                        <div className="stat">
                            <div className="stat-num">12.4k</div>
                            <div className="stat-label">Usuarios activos</div>
                        </div>
                        <div className="stat">
                            <div className="stat-num">3.8t</div>
                            <div className="stat-label">Residuos reciclados</div>
                        </div>
                        <div className="stat">
                            <div className="stat-num">847</div>
                            <div className="stat-label">Puntos de recogida</div>
                        </div>
                    </div>
                </div>

                {/* Right form panel */}
                <div className="right-panel">
                    <div className="form-header">
                        <div className="points-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            Gana 50 puntos al iniciar sesión hoy
                        </div>
                        <h2>Bienvenido de nuevo</h2>
                        <p>¿No tienes cuenta? <Link href={route('register')}>Regístrate gratis</Link></p>
                    </div>

                    {status && <div className="status-msg">{status}</div>}

                    <form onSubmit={submit}>
                        <div className="form-group">
                            <label className="form-label" htmlFor="email">Correo electrónico</label>
                            <div className="input-wrap">
                                <span className="input-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                </span>
                                <input
                                    id="email"
                                    type="email"
                                    className={`form-input${errors.email ? ' error' : ''}`}
                                    placeholder="usuario@email.com"
                                    value={data.email}
                                    autoComplete="username"
                                    onChange={e => setData('email', e.target.value)}
                                />
                            </div>
                            {errors.email && <p className="field-error">{errors.email}</p>}
                        </div>

                        <div className="form-group">
                            <label className="form-label" htmlFor="password">Contraseña</label>
                            <div className="input-wrap">
                                <span className="input-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    type={showPassword ? 'text' : 'password'}
                                    className={`form-input${errors.password ? ' error' : ''}`}
                                    placeholder="••••••••"
                                    value={data.password}
                                    autoComplete="current-password"
                                    onChange={e => setData('password', e.target.value)}
                                />
                                <button type="button" className="toggle-pass" onClick={() => setShowPassword(v => !v)}>
                                    {showPassword ? (
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    ) : (
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    )}
                                </button>
                            </div>
                            {errors.password && <p className="field-error">{errors.password}</p>}
                        </div>

                        <div className="form-footer">
                            <label className="remember">
                                <input
                                    type="checkbox"
                                    checked={data.remember}
                                    onChange={e => setData('remember', e.target.checked as false)}
                                />
                                Recordarme
                            </label>
                            {canResetPassword && (
                                <Link href={route('password.request')} className="forgot">
                                    ¿Olvidaste tu contraseña?
                                </Link>
                            )}
                        </div>

                        <button type="submit" className="btn-login" disabled={processing}>
                            {processing ? (
                                <>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{ animation: 'spin 1s linear infinite' }}>
                                        <path d="M21 12a9 9 0 11-6.219-8.56" />
                                    </svg>
                                    Iniciando sesión...
                                </>
                            ) : (
                                <>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                                        <polyline points="10 17 15 12 10 7" />
                                        <line x1="15" y1="12" x2="3" y2="12" />
                                    </svg>
                                    Iniciar sesión
                                </>
                            )}
                        </button>

                        <div className="divider">
                            <div className="divider-line"></div>
                            <span className="divider-text">o continúa con</span>
                            <div className="divider-line"></div>
                        </div>

                        <button type="button" className="btn-google">
                            <svg width="18" height="18" viewBox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                            </svg>
                            Continuar con Google
                        </button>
                    </form>

                    <style>{`@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }`}</style>
                </div>
            </div>
        </>
    );
}
