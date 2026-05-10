import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

export default function Login({ status, canResetPassword }: { status?: string; canResetPassword: boolean }) {
    const { data, setData, post, processing, errors, reset } = useForm({ email: '', password: '', remember: false as boolean });
    const [showPw, setShowPw] = useState(false);
    const submit: FormEventHandler = e => { e.preventDefault(); post(route('login'), { onFinish: () => reset('password') }); };

    return (
        <>
            <Head title="Iniciar sesión" />
            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap');
                *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
                body{font-family:'DM Sans',sans-serif;}
                .wrap{min-height:100vh;display:grid;grid-template-columns:1fr 1fr;}
                @media(max-width:768px){.wrap{grid-template-columns:1fr}.left-p{display:none}}
                .left-p{background:#1a3a2a;position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:space-between;padding:3rem;}
                .brand{position:relative;z-index:2;display:flex;align-items:center;gap:10px;}
                .brand-dot{width:34px;height:34px;background:#52b788;border-radius:50%;display:flex;align-items:center;justify-content:center;}
                .brand-name{font-family:'DM Serif Display',serif;font-size:20px;color:#fff;}
                .tagline{position:relative;z-index:2;}
                .tagline h1{font-family:'DM Serif Display',serif;font-size:40px;color:#fff;line-height:1.15;letter-spacing:-1px;margin-bottom:1rem;}
                .tagline h1 em{color:#52b788;font-style:italic;}
                .tagline p{color:rgba(255,255,255,0.55);font-size:15px;line-height:1.7;max-width:280px;font-weight:300;}
                .stats{position:relative;z-index:2;display:flex;gap:2rem;}
                .stat{border-top:1px solid rgba(255,255,255,0.12);padding-top:1rem;}
                .stat-n{font-family:'DM Serif Display',serif;font-size:26px;color:#52b788;}
                .stat-l{font-size:11px;color:rgba(255,255,255,0.45);margin-top:2px;text-transform:uppercase;letter-spacing:0.5px;}
                .right-p{display:flex;flex-direction:column;justify-content:center;padding:4rem 3.5rem;background:#f8f5f0;overflow-y:auto;}
                .pts-badge{display:inline-flex;align-items:center;gap:6px;background:#d8f3dc;color:#2d6a4f;font-size:12px;font-weight:500;padding:5px 12px;border-radius:20px;margin-bottom:1.5rem;}
                .fh h2{font-family:'DM Serif Display',serif;font-size:30px;color:#1a3a2a;letter-spacing:-0.5px;margin-bottom:6px;}
                .fh p{font-size:14px;color:#6b7c6d;font-weight:300;}
                .fh p a{color:#2d6a4f;font-weight:500;text-decoration:none;}
                .fg{margin-bottom:1.15rem;}
                .fl{display:block;font-size:11px;font-weight:600;color:#6b7c6d;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:5px;}
                .iw{position:relative;}
                .ii{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;display:flex;pointer-events:none;}
                .fi{width:100%;height:48px;padding:0 14px 0 40px;border:1.5px solid #ddd;border-radius:10px;font-size:15px;font-family:'DM Sans',sans-serif;color:#1c1c1c;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s;}
                .fi:focus{border-color:#2d6a4f;box-shadow:0 0 0 3px rgba(45,106,79,.08);}
                .fi.err{border-color:#e53e3e;}
                .fi::placeholder{color:#bbb;font-weight:300;}
                .eye-btn{position:absolute;right:13px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;padding:0;display:flex;}
                .fe{font-size:12px;color:#e53e3e;margin-top:4px;}
                .ff{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;}
                .rem{display:flex;align-items:center;gap:7px;font-size:13px;color:#6b7c6d;cursor:pointer;}
                .rem input{accent-color:#2d6a4f;width:15px;height:15px;}
                .forgot{font-size:13px;color:#2d6a4f;font-weight:500;text-decoration:none;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;}
                .btn-login{width:100%;height:50px;background:#1a3a2a;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:500;font-family:'DM Sans',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .2s,transform .15s;}
                .btn-login:hover:not(:disabled){background:#2d6a4f;transform:translateY(-1px);}
                .btn-login:disabled{opacity:.6;cursor:not-allowed;}
                .divider{display:flex;align-items:center;gap:10px;margin:1.25rem 0;}
                .dvl{flex:1;height:1px;background:#e0e0e0;}
                .dvt{font-size:12px;color:#bbb;}
                .btn-g{width:100%;height:48px;background:#fff;border:1.5px solid #e0e0e0;border-radius:10px;font-size:14px;font-weight:500;color:#374151;font-family:'DM Sans',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:border-color .2s,box-shadow .2s;}
                .btn-g:hover{border-color:#bbb;box-shadow:0 2px 8px rgba(0,0,0,.06);}
                .status-msg{background:#f0fdf4;border:1px solid #bbf7d0;color:#2d6a4f;font-size:13px;padding:9px 13px;border-radius:8px;margin-bottom:1rem;}
                @keyframes spin{to{transform:rotate(360deg)}}
            `}</style>
            <div className="wrap">
                <div className="left-p">
                    <svg style={{ position:'absolute',inset:0,pointerEvents:'none' }} viewBox="0 0 600 800" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="500" cy="100" rx="280" ry="200" fill="rgba(82,183,136,0.07)" transform="rotate(-20 500 100)"/>
                        <ellipse cx="-60" cy="700" rx="320" ry="220" fill="rgba(82,183,136,0.06)" transform="rotate(15 -60 700)"/>
                        <path d="M80 200 Q160 120 200 200 Q160 280 80 200Z" fill="rgba(82,183,136,0.12)" transform="rotate(-10 140 200)"/>
                    </svg>
                    <div className="brand">
                        <div className="brand-dot">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a3a2a" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 7.19 7 5c-.29 2.19-1.14 3.31-2.29 4.06C3.57 9.99 3 11.09 3 12.25 3 14.47 4.8 16.3 7 16.3z"/>
                                <path d="M12.56 6.6A10.97 10.97 0 0014 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 01-11.91 4.97"/>
                            </svg>
                        </div>
                        <span className="brand-name">Ecocycle</span>
                    </div>
                    <div className="tagline">
                        <h1>Recicla.<br/>Gana puntos.<br/><em>Marca la diferencia.</em></h1>
                        <p>Únete a miles de usuarios comprometidos con el medio ambiente. Cada acción de reciclaje suma puntos y contribuye a un planeta más limpio.</p>
                    </div>
                    <div className="stats">
                        
                    </div>
                </div>

                <div className="right-p">
                    <div className="fh" style={{ marginBottom:'2rem' }}>
                
                        <h2>Bienvenido de nuevo</h2>
                        <p>¿No tienes cuenta? <Link href={route('register')}>Regístrate gratis</Link></p>
                    </div>
                    {status && <div className="status-msg">{status}</div>}
                    <form onSubmit={submit}>
                        <div className="fg">
                            <label className="fl">Correo electrónico</label>
                            <div className="iw">
                                <span className="ii"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
                                <input type="email" className={`fi${errors.email?' err':''}`} placeholder="usuario@email.com" value={data.email} autoComplete="username" onChange={e=>setData('email',e.target.value)}/>
                            </div>
                            {errors.email && <p className="fe">{errors.email}</p>}
                        </div>
                        <div className="fg">
                            <label className="fl">Contraseña</label>
                            <div className="iw">
                                <span className="ii"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></span>
                                <input type={showPw?'text':'password'} className={`fi${errors.password?' err':''}`} placeholder="••••••••" value={data.password} autoComplete="current-password" onChange={e=>setData('password',e.target.value)}/>
                                <button type="button" className="eye-btn" onClick={()=>setShowPw(v=>!v)}>
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        {showPw?<><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></>:<><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></>}
                                    </svg>
                                </button>
                            </div>
                            {errors.password && <p className="fe">{errors.password}</p>}
                        </div>
                        <div className="ff">
                            <label className="rem"><input type="checkbox" checked={data.remember} onChange={e=>setData('remember',e.target.checked as false)}/> Recordarme</label>
{/*                            {canResetPassword && <Link href={route('password.request')} className="forgot">¿Olvidaste tu contraseña?</Link>}
*/}                        </div>
                        <button type="submit" className="btn-login" disabled={processing}>
                            {processing?<><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{animation:'spin 1s linear infinite'}}><path d="M21 12a9 9 0 11-6.219-8.56"/></svg>Iniciando...</>:<>Iniciar sesión</>}
                        </button>
                        
                        
                    </form>
                </div>
            </div>
        </>
    );
}
