import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({ name:'', email:'', password:'', password_confirmation:'' });
    const [showPw, setShowPw] = useState(false);
    const submit: FormEventHandler = e => { e.preventDefault(); post(route('register'), { onFinish:()=>reset('password','password_confirmation') }); };

    return (
        <>
            <Head title="Crear cuenta"/>
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
                .tagline h1{font-family:'DM Serif Display',serif;font-size:36px;color:#fff;line-height:1.15;letter-spacing:-1px;margin-bottom:1rem;}
                .tagline h1 em{color:#52b788;font-style:italic;}
                .tagline p{color:rgba(255,255,255,0.55);font-size:14px;line-height:1.7;max-width:280px;font-weight:300;}
                .perks{position:relative;z-index:2;display:flex;flex-direction:column;gap:12px;}
                .perk{display:flex;align-items:center;gap:12px;}
                .perk-icon{width:34px;height:34px;border-radius:8px;background:rgba(82,183,136,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
                .perk-text{font-size:13px;color:rgba(255,255,255,0.7);font-weight:300;}
                .perk-text strong{display:block;color:#fff;font-weight:500;font-size:13px;}
                .right-p{display:flex;flex-direction:column;justify-content:center;padding:3rem 3.5rem;background:#f8f5f0;overflow-y:auto;}
                .fh h2{font-family:'DM Serif Display',serif;font-size:28px;color:#1a3a2a;letter-spacing:-0.5px;margin-bottom:6px;}
                .fh p{font-size:14px;color:#6b7c6d;font-weight:300;margin-bottom:1.75rem;}
                .fh p a{color:#2d6a4f;font-weight:500;text-decoration:none;}
                .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 1rem;}
                .fg{margin-bottom:1.1rem;}
                .fg.full{grid-column:span 2;}
                .fl{display:block;font-size:11px;font-weight:600;color:#6b7c6d;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:5px;}
                .iw{position:relative;}
                .ii{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;display:flex;pointer-events:none;}
                .fi{width:100%;height:46px;padding:0 14px 0 40px;border:1.5px solid #ddd;border-radius:10px;font-size:14px;font-family:'DM Sans',sans-serif;color:#1c1c1c;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s;}
                .fi:focus{border-color:#2d6a4f;box-shadow:0 0 0 3px rgba(45,106,79,.08);}
                .fi.err{border-color:#e53e3e;}
                .fi::placeholder{color:#bbb;font-weight:300;}
                .eye-btn{position:absolute;right:13px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;padding:0;display:flex;}
                .fe{font-size:12px;color:#e53e3e;margin-top:4px;}
                .btn-reg{width:100%;height:50px;background:#1a3a2a;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:500;font-family:'DM Sans',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .2s,transform .15s;margin-top:.25rem;}
                .btn-reg:hover:not(:disabled){background:#2d6a4f;transform:translateY(-1px);}
                .btn-reg:disabled{opacity:.6;cursor:not-allowed;}
                .terms{font-size:12px;color:#9ca3af;text-align:center;margin-top:.9rem;line-height:1.6;}
                .terms a{color:#2d6a4f;text-decoration:none;}
                @keyframes spin{to{transform:rotate(360deg)}}
            `}</style>
            <div className="wrap">
                <div className="left-p">
                    <svg style={{position:'absolute',inset:0,pointerEvents:'none'}} viewBox="0 0 600 800" xmlns="http://www.w3.org/2000/svg">
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
                        <h1>Únete a la <em>revolución verde</em></h1>
                        <p>Crea tu cuenta y empieza a ganar puntos por cada acción de reciclaje. Tu impacto importa.</p>
                    </div>
                    <div className="perks">
                        {[
                            { title:'Sistema de puntos',    desc:'Gana recompensas por cada reciclaje',    emoji:'⭐' },
                            { title:'Geolocalización de puntos',        desc:'Puntos de recogida por toda Valencia',       emoji:'📍' }
                        ].map((p,i)=>(
                            <div key={i} className="perk">
                                <div className="perk-icon"><span style={{fontSize:16}}>{p.emoji}</span></div>
                                <div className="perk-text"><strong>{p.title}</strong>{p.desc}</div>
                            </div>
                        ))}
                    </div>
                </div>
                <div className="right-p">
                    <div className="fh">
                        <h2>Crear cuenta</h2>
                        <p>¿Ya tienes cuenta? <Link href={route('login')}>Inicia sesión</Link></p>
                    </div>
                    <form onSubmit={submit}>
                        <div className="form-grid">
                            <div className="fg full">
                                <label className="fl">Nombre completo</label>
                                <div className="iw">
                                    <span className="ii"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                                    <input type="text" className={`fi${errors.name?' err':''}`} placeholder="Tu nombre" value={data.name} autoComplete="name" onChange={e=>setData('name',e.target.value)}/>
                                </div>
                                {errors.name&&<p className="fe">{errors.name}</p>}
                            </div>
                            <div className="fg full">
                                <label className="fl">Correo electrónico</label>
                                <div className="iw">
                                    <span className="ii"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
                                    <input type="email" className={`fi${errors.email?' err':''}`} placeholder="usuario@email.com" value={data.email} autoComplete="username" onChange={e=>setData('email',e.target.value)}/>
                                </div>
                                {errors.email&&<p className="fe">{errors.email}</p>}
                            </div>
                            <div className="fg">
                                <label className="fl">Contraseña</label>
                                <div className="iw">
                                    <span className="ii"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></span>
                                    <input type={showPw?'text':'password'} className={`fi${errors.password?' err':''}`} placeholder="Mín. 8 caracteres" value={data.password} autoComplete="new-password" onChange={e=>setData('password',e.target.value)}/>
                                    <button type="button" className="eye-btn" onClick={()=>setShowPw(v=>!v)}>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            {showPw?<><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></>:<><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></>}
                                        </svg>
                                    </button>
                                </div>
                                {errors.password&&<p className="fe">{errors.password}</p>}
                            </div>
                            <div className="fg">
                                <label className="fl">Confirmar contraseña</label>
                                <div className="iw">
                                    <span className="ii"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></span>
                                    <input type="password" className={`fi${errors.password_confirmation?' err':''}`} placeholder="••••••••" value={data.password_confirmation} autoComplete="new-password" onChange={e=>setData('password_confirmation',e.target.value)}/>
                                </div>
                                {errors.password_confirmation&&<p className="fe">{errors.password_confirmation}</p>}
                            </div>
                        </div>
                        <button type="submit" className="btn-reg" disabled={processing}>
                            {processing?<><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{animation:'spin 1s linear infinite'}}><path d="M21 12a9 9 0 11-6.219-8.56"/></svg>Creando cuenta...</>:<>Crear cuenta gratis</>}
                        </button>
                        <p className="terms">Al registrarte aceptas nuestros <a href="#">Términos de uso</a> y <a href="#">Política de privacidad</a></p>
                    </form>
                </div>
            </div>
        </>
    );
}
