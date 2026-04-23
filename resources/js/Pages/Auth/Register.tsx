import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const [showPassword, setShowPassword] = useState(false);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <>
            <Head title="Registro" />

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap');
                * { box-sizing: border-box; margin: 0; padding: 0; }
                :root {
                    --green-dark: #1a3a2a; --green-mid: #2d6a4f;
                    --green-light: #52b788; --green-pale: #d8f3dc;
                    --cream: #f8f5f0; --text-dark: #1c1c1c; --text-muted: #6b7c6d;
                }
                html, body { height: 100%; }
                .reg-wrap {
                    min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr;
                    font-family: 'DM Sans', sans-serif; background: var(--cream);
                }
                @media (max-width: 768px) { .reg-wrap { grid-template-columns: 1fr; } .left-panel { display: none; } }
                .left-panel {
                    background: var(--green-dark); position: relative; overflow: hidden;
                    display: flex; flex-direction: column; justify-content: space-between; padding: 3rem;
                }
                .leaf-bg { position: absolute; inset: 0; pointer-events: none; }
                .brand { position: relative; z-index: 2; display: flex; align-items: center; gap: 10px; }
                .brand-icon { width:36px; height:36px; background: var(--green-light); border-radius:50%; display:flex; align-items:center; justify-content:center; }
                .brand-name { font-family:'DM Serif Display',serif; font-size:22px; color:#fff; letter-spacing:-0.3px; }
                .tagline-block { position: relative; z-index: 2; }
                .tagline-block h1 { font-family:'DM Serif Display',serif; font-size:38px; color:#fff; line-height:1.15; letter-spacing:-1px; margin-bottom:1.2rem; }
                .tagline-block h1 em { color: var(--green-light); font-style: italic; }
                .tagline-block p { color:rgba(255,255,255,0.6); font-size:15px; line-height:1.7; max-width:300px; font-weight:300; }
                .perks { position: relative; z-index: 2; display: flex; flex-direction: column; gap: 1rem; }
                .perk { display: flex; align-items: center; gap: 12px; }
                .perk-icon { width:36px; height:36px; border-radius:8px; background:rgba(82,183,136,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
                .perk-text { font-size:14px; color:rgba(255,255,255,0.75); font-weight:300; }
                .perk-text strong { color:#fff; font-weight:500; display:block; font-size:14px; }
                .right-panel { display:flex; flex-direction:column; justify-content:center; padding:3rem 3.5rem; overflow-y:auto; }
                .form-header { margin-bottom:2rem; }
                .form-header h2 { font-family:'DM Serif Display',serif; font-size:30px; color:var(--text-dark); letter-spacing:-0.5px; margin-bottom:0.5rem; }
                .form-header p { font-size:14px; color:var(--text-muted); font-weight:300; }
                .form-header p a { color:var(--green-mid); font-weight:500; text-decoration:none; }
                .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 1rem; }
                .form-group { margin-bottom:1.1rem; }
                .form-group.full { grid-column: span 2; }
                .form-label { display:block; font-size:12px; font-weight:500; color:var(--text-muted); letter-spacing:0.6px; text-transform:uppercase; margin-bottom:0.5rem; }
                .input-wrap { position:relative; }
                .input-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none; display:flex; }
                .form-input { width:100%; height:48px; padding:0 16px 0 42px; border:1.5px solid #ddd; border-radius:10px; font-size:15px; font-family:'DM Sans',sans-serif; color:var(--text-dark); background:#fff; outline:none; transition:border-color 0.2s, box-shadow 0.2s; }
                .form-input:focus { border-color:var(--green-mid); box-shadow:0 0 0 3px rgba(45,106,79,0.08); }
                .form-input::placeholder { color:#bbb; font-weight:300; }
                .form-input.error { border-color:#e53e3e; }
                .toggle-pass { position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0; display:flex; align-items:center; }
                .field-error { font-size:12px; color:#e53e3e; margin-top:5px; }
                .btn-register { width:100%; height:52px; background:var(--green-dark); color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:background 0.2s, transform 0.15s; margin-top:0.5rem; }
                .btn-register:hover:not(:disabled) { background:var(--green-mid); transform:translateY(-1px); }
                .btn-register:disabled { opacity:0.6; cursor:not-allowed; }
                .terms { font-size:12px; color:var(--text-muted); text-align:center; margin-top:1rem; line-height:1.6; }
                .terms a { color:var(--green-mid); text-decoration:none; }
                @keyframes spin { from { transform:rotate(0deg); } to { transform:rotate(360deg); } }
            `}</style>

            <div className="reg-wrap">
                <div className="left-panel">
                    <svg className="leaf-bg" viewBox="0 0 600 800" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="500" cy="100" rx="280" ry="200" fill="rgba(82,183,136,0.07)" transform="rotate(-20 500 100)" />
                        <ellipse cx="-60" cy="700" rx="320" ry="220" fill="rgba(82,183,136,0.06)" transform="rotate(15 -60 700)" />
                        <path d="M80 200 Q160 120 200 200 Q160 280 80 200Z" fill="rgba(82,183,136,0.12)" transform="rotate(-10 140 200)" />
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
                        <h1>Únete a la <em>revolución verde</em></h1>
                        <p>Crea tu cuenta y empieza a ganar puntos por cada acción de reciclaje. Tu impacto importa.</p>
                    </div>

                    <div className="perks">
                        {[
                            { icon: '★', title: 'Sistema de puntos', desc: 'Gana recompensas por cada reciclaje' },
                            { icon: '⬡', title: 'Red de puntos', desc: '847 puntos de recogida en tu ciudad' },
                            { icon: '↑', title: 'Sube de nivel', desc: 'De Beginner a Expert reciclando' },
                        ].map((p, i) => (
                            <div className="perk" key={i}>
                                <div className="perk-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#52b788" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                                <div className="perk-text">
                                    <strong>{p.title}</strong>
                                    {p.desc}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                <div className="right-panel">
                    <div className="form-header">
                        <h2>Crear cuenta</h2>
                        <p>¿Ya tienes cuenta? <Link href={route('login')}>Inicia sesión</Link></p>
                    </div>

                    <form onSubmit={submit}>
                        <div className="form-grid">
                            <div className="form-group full">
                                <label className="form-label" htmlFor="name">Nombre completo</label>
                                <div className="input-wrap">
                                    <span className="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" /><circle cx="12" cy="7" r="4" />
                                        </svg>
                                    </span>
                                    <input id="name" type="text" className={`form-input${errors.name ? ' error' : ''}`} placeholder="Tu nombre" value={data.name} autoComplete="name" onChange={e => setData('name', e.target.value)} />
                                </div>
                                {errors.name && <p className="field-error">{errors.name}</p>}
                            </div>

                            <div className="form-group full">
                                <label className="form-label" htmlFor="email">Correo electrónico</label>
                                <div className="input-wrap">
                                    <span className="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" /><polyline points="22,6 12,13 2,6" />
                                        </svg>
                                    </span>
                                    <input id="email" type="email" className={`form-input${errors.email ? ' error' : ''}`} placeholder="usuario@email.com" value={data.email} autoComplete="username" onChange={e => setData('email', e.target.value)} />
                                </div>
                                {errors.email && <p className="field-error">{errors.email}</p>}
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="password">Contraseña</label>
                                <div className="input-wrap">
                                    <span className="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" /><path d="M7 11V7a5 5 0 0110 0v4" />
                                        </svg>
                                    </span>
                                    <input id="password" type={showPassword ? 'text' : 'password'} className={`form-input${errors.password ? ' error' : ''}`} placeholder="••••••••" value={data.password} autoComplete="new-password" onChange={e => setData('password', e.target.value)} />
                                    <button type="button" className="toggle-pass" onClick={() => setShowPassword(v => !v)}>
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            {showPassword ? <><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" /><line x1="1" y1="1" x2="23" y2="23" /></> : <><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" /><circle cx="12" cy="12" r="3" /></>}
                                        </svg>
                                    </button>
                                </div>
                                {errors.password && <p className="field-error">{errors.password}</p>}
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="password_confirmation">Confirmar contraseña</label>
                                <div className="input-wrap">
                                    <span className="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" /><path d="M7 11V7a5 5 0 0110 0v4" />
                                        </svg>
                                    </span>
                                    <input id="password_confirmation" type="password" className={`form-input${errors.password_confirmation ? ' error' : ''}`} placeholder="••••••••" value={data.password_confirmation} autoComplete="new-password" onChange={e => setData('password_confirmation', e.target.value)} />
                                </div>
                                {errors.password_confirmation && <p className="field-error">{errors.password_confirmation}</p>}
                            </div>
                        </div>

                        <button type="submit" className="btn-register" disabled={processing}>
                            {processing ? (
                                <><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{ animation: 'spin 1s linear infinite' }}><path d="M21 12a9 9 0 11-6.219-8.56" /></svg>Creando cuenta...</>
                            ) : (
                                <><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><circle cx="8.5" cy="7" r="4" /><line x1="20" y1="8" x2="20" y2="14" /><line x1="23" y1="11" x2="17" y2="11" /></svg>Crear cuenta gratis</>
                            )}
                        </button>

                        <p className="terms">Al registrarte aceptas nuestros <a href="#">Términos de uso</a> y <a href="#">Política de privacidad</a></p>
                    </form>
                </div>
            </div>
        </>
    );
}
