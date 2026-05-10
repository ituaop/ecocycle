import { Head, useForm } from '@inertiajs/react';
import { useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface WasteItem {
    id: string;
    name: string;
    description: string;
    category: string;
    points: number;
}

interface CollectionPoint {
    id: string;
    name: string;
    address: string;
    latitude: number;
    longitude: number;
    schedule: string | null;
    accepted_categories: string[];
}

interface Props extends PageProps {
    wasteItemsByCategory: Record<string, WasteItem[]>;
    collectionPoints: CollectionPoint[];
}

const CAT_META: Record<string, { label: string; emoji: string; color: string; bg: string }> = {
    PLASTIC:    { label: 'Plástico',    emoji: '🧴', color: '#1d4ed8', bg: '#eff6ff' },
    GLASS:      { label: 'Vidrio',      emoji: '🍶', color: '#0d9488', bg: '#f0fdfa' },
    PAPER:      { label: 'Papel',       emoji: '📄', color: '#a16207', bg: '#fefce8' },
    METAL:      { label: 'Metal',       emoji: '🥫', color: '#3f3f46', bg: '#f4f4f5' },
    ORGANIC:    { label: 'Orgánico',    emoji: '🌿', color: '#15803d', bg: '#f0fdf4' },
    ELECTRONIC: { label: 'Electrónico', emoji: '📱', color: '#7e22ce', bg: '#fdf4ff' },
    OTHER:      { label: 'Otro',        emoji: '♻️', color: '#c2410c', bg: '#fff7ed' },
};

export default function RecycleIndex({ wasteItemsByCategory, collectionPoints }: Props) {
    const [step, setStep]                   = useState<1 | 2 | 3>(1);
    const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
    const [selectedItem, setSelectedItem]   = useState<WasteItem | null>(null);

    const { data, setData, post, processing, errors } = useForm({
        waste_item_id:       '',
        collection_point_id: '',
        quantity:            1,
        date:                new Date().toISOString().split('T')[0],
    });

    const categories     = Object.keys(wasteItemsByCategory);
    const itemsInCat     = selectedCategory ? (wasteItemsByCategory[selectedCategory] ?? []) : [];
    const estimatedPts   = selectedItem ? selectedItem.points * data.quantity : 0;
    const eligibleCPs    = selectedCategory
        ? collectionPoints.filter(cp => cp.accepted_categories?.includes(selectedCategory))
        : collectionPoints;
    const selectedCP     = collectionPoints.find(cp => cp.id === data.collection_point_id);

    const pickItem = (item: WasteItem, cat: string) => {
        setSelectedItem(item);
        setSelectedCategory(cat);
        setData('waste_item_id', item.id);
        setData('collection_point_id', '');
        setStep(2);
    };

    const pickCP = (cpId: string) => {
        setData('collection_point_id', cpId);
        setStep(3);
    };

    return (
        <AppLayout header={
            <div>
                <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 22, color: '#1a3a2a', margin: 0 }}>
                    Reciclar
                </h1>
                <p style={{ fontSize: 13, color: '#6b7c6d', margin: '3px 0 0', fontWeight: 300 }}>
                    Selecciona qué has reciclado hoy y gana puntos
                </p>
            </div>
        }>
            <Head title="Reciclar" />

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');

                /* barra de pasos */
                .steps { display:flex; background:#fff; border-radius:12px; border:1px solid #e8ebe6; overflow:hidden; margin-bottom:1.5rem; }
                .paso { flex:1; display:flex; align-items:center; gap:9px; padding:13px 18px; font-size:13.5px; color:#9ca3af; border-right:1px solid #f0f0ee; cursor:pointer; transition:background 0.15s; user-select:none; }
                .paso:last-child { border-right:none; }
                .paso.done { color:#2d6a4f; }
                .paso.active { background:#f0fdf4; color:#1a3a2a; font-weight:500; }
                .paso-num { width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; background:#f0f0ee; color:#9ca3af; flex-shrink:0; transition:all 0.15s; }
                .paso.active .paso-num { background:#52b788; color:#fff; }
                .paso.done   .paso-num { background:#2d6a4f; color:#fff; }
                @media(max-width:600px){ .paso { padding:10px 12px; font-size:12px; gap:6px; } }

                /* categoria */
                .categoria-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(130px,1fr)); gap:10px; margin-bottom:1.5rem; }
                .categoria-boton  { padding:16px 10px; border-radius:12px; border:2px solid #e8ebe6; background:#fff; cursor:pointer; text-align:center; transition:all 0.15s; display:flex; flex-direction:column; align-items:center; gap:7px; font-family:'DM Sans',sans-serif; }
                .categoria-boton:hover   { transform:translateY(-2px); box-shadow:0 4px 14px rgba(0,0,0,0.08); border-color:#52b788; }
                .categoria-boton.sel     { border-width:2px; }
                .categoria-emoji       { font-size:30px; line-height:1; }
                .categoria-label       { font-size:13px; font-weight:600; }
                .categoria-count       { font-size:11px; color:#9ca3af; }

                /* grid */
                .item-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(230px,1fr)); gap:10px; }
                .item-card { padding:15px; border-radius:12px; border:2px solid #e8ebe6; background:#fff; cursor:pointer; transition:all 0.15s; }
                .item-card:hover { border-color:#52b788; transform:translateY(-2px); box-shadow:0 4px 14px rgba(0,0,0,0.07); }
                .item-card.sel   { border-color:#2d6a4f; background:#f0fdf4; }
                .item-name  { font-size:14px; font-weight:600; color:#1a3a2a; margin-bottom:5px; }
                .item-desc  { font-size:12px; color:#6b7c6d; line-height:1.5; margin-bottom:10px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
                .item-pts   { font-size:13px; font-weight:700; color:#2d6a4f; }
                .item-sel-hint { font-size:11px; color:#52b788; font-weight:500; }

                /* lista punto de recogida */
                .puntoreciclaje-card { display:flex; align-items:flex-start; gap:12px; padding:14px 16px; border-radius:12px; border:2px solid #e8ebe6; background:#fff; cursor:pointer; transition:all 0.15s; margin-bottom:8px; }
                .puntoreciclaje-card:hover { border-color:#52b788; }
                .puntoreciclaje-card.sel   { border-color:#2d6a4f; background:#f0fdf4; }
                .puntoreciclaje-icon { font-size:22px; flex-shrink:0; margin-top:2px; }
                .puntoreciclaje-name { font-size:14px; font-weight:600; color:#1a3a2a; margin-bottom:3px; }
                .puntoreciclaje-addr { font-size:12px; color:#6b7c6d; margin-bottom:3px; }
                .puntoreciclaje-sched{ font-size:11px; color:#9ca3af; }
                .puntoreciclaje-cats { display:flex; flex-wrap:wrap; gap:4px; margin-top:6px; }
                .puntoreciclaje-categoria-chip { font-size:10px; font-weight:600; padding:2px 7px; border-radius:8px; }

                /* confirmacion */
                .confirm-box { background:#fff; border-radius:14px; border:1px solid #e8ebe6; padding:1.75rem; max-width:500px; margin:0 auto; }
                .pts-preview { display:flex; align-items:center; gap:9px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:11px 15px; margin-bottom:1.25rem; font-size:14px; color:#15803d; font-weight:500; }
                .summary-row { display:flex; justify-content:space-between; padding:9px 0; border-bottom:1px solid #f0f0ee; font-size:14px; }
                .summary-row:last-of-type { border-bottom:none; }
                .qty-row { display:flex; align-items:center; gap:14px; margin-bottom:1.1rem; }
                .qty-boton { width:38px; height:38px; border:1.5px solid #e0e0e0; border-radius:9px; background:#fff; font-size:20px; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#1a3a2a; transition:border-color 0.15s; font-family:'DM Sans',sans-serif; }
                .qty-boton:hover { border-color:#52b788; }
                .qty-num { font-size:22px; font-weight:700; color:#1a3a2a; min-width:40px; text-align:center; }
                .date-input { width:100%; height:44px; padding:0 12px; border:1.5px solid #e0e0e0; border-radius:10px; font-size:14px; font-family:'DM Sans',sans-serif; outline:none; transition:border-color 0.2s; margin-bottom:1.25rem; }
                .date-input:focus { border-color:#2d6a4f; }
                .formulario-lbl { font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; display:block; }
                .boton-submit { width:100%; height:50px; background:#1a3a2a; color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:500; font-family:'DM Sans',sans-serif; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:background 0.15s, transform 0.15s; }
                .boton-submit:hover:not(:disabled) { background:#2d6a4f; transform:translateY(-1px); }
                .boton-submit:disabled { opacity:0.6; cursor:not-allowed; }
                .boton-back { flex:1; height:46px; background:transparent; border:1.5px solid #e0e0e0; border-radius:11px; font-size:14px; cursor:pointer; color:#374151; font-family:'DM Sans',sans-serif; transition:border-color 0.15s; }
                .boton-back:hover { border-color:#9ca3af; }
                .field-err { font-size:12px; color:#e53e3e; margin-top:5px; }

                /* elegir tipo */
                .sel-badge { display:flex; align-items:center; gap:10px; background:#fff; border:1px solid #e8ebe6; border-radius:12px; padding:10px 14px; margin-bottom:1rem; }
                .sel-badge-name { font-weight:600; color:#1a3a2a; font-size:14px; }
                .sel-badge-sub  { font-size:12px; color:#9ca3af; }
                .boton-change { margin-left:auto; font-size:12px; color:#2d6a4f; font-weight:500; background:none; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; }

                /* vacio */
                .empty { padding:2.5rem; text-align:center; background:#fff; border-radius:14px; border:1px solid #e8ebe6; }
                .empty p { font-size:14px; color:#9ca3af; margin:12px 0 0; }

                @keyframes spin { to { transform:rotate(360deg); } }
            `}</style>

            {/* pasos para completar */}
            <div className="steps">
                {[
                    { n: 1, label: 'Material' },
                    { n: 2, label: 'Punto de recogida' },
                    { n: 3, label: 'Confirmar' },
                ].map(s => (
                    <div
                        key={s.n}
                        className={`paso${step === s.n ? ' active' : step > s.n ? ' done' : ''}`}
                        onClick={() => step > s.n && setStep(s.n as 1 | 2 | 3)}
                    >
                        <div className="paso-num">
                            {step > s.n ? '✓' : s.n}
                        </div>
                        <span>{s.label}</span>
                    </div>
                ))}
            </div>

            {/* ─── paso 1 ─────────────────────────────────── */}
            {step === 1 && (
                <div>
                    {/* Categorías */}
                    <div className="categoria-grid">
                        {categories.map(cat => {
                            const cm = CAT_META[cat] ?? CAT_META.OTHER;
                            const isSel = selectedCategory === cat;
                            return (
                                <button
                                    key={cat}
                                    className={`categoria-boton${isSel ? ' sel' : ''}`}
                                    style={{
                                        borderColor:      isSel ? cm.color : undefined,
                                        backgroundColor:  isSel ? cm.bg : undefined,
                                        color:            isSel ? cm.color : undefined,
                                    }}
                                    onClick={() => { setSelectedCategory(cat); setSelectedItem(null); }}
                                >
                                    <span className="categoria-emoji">{cm.emoji}</span>
                                    <span className="categoria-label">{cm.label}</span>
                                    <span className="categoria-count">{wasteItemsByCategory[cat].length} materiales</span>
                                </button>
                            );
                        })}
                    </div>

                    {/* materiales */}
                    {selectedCategory ? (
                        <>
                            <p style={{ fontSize: 13, fontWeight: 600, color: '#6b7c6d', marginBottom: '0.75rem' }}>
                                {CAT_META[selectedCategory]?.emoji} Materiales de {CAT_META[selectedCategory]?.label}:
                            </p>
                            <div className="item-grid">
                                {itemsInCat.map(item => (
                                    <div
                                        key={item.id}
                                        className={`item-card${selectedItem?.id === item.id ? ' sel' : ''}`}
                                        onClick={() => pickItem(item, selectedCategory)}
                                    >
                                        <div className="item-name">{item.name}</div>
                                        <div className="item-desc">{item.description}</div>
                                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                            <span className="item-pts"> {item.points} pts/ud</span>
                                            <span className="item-sel-hint">Seleccionar →</span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </>
                    ) : (
                        <div style={{ textAlign: 'center', padding: '2rem', color: '#9ca3af', fontSize: 14 }}>
                             Elige para ver los materiales disponibles
                        </div>
                    )}
                </div>
            )}

            {/* ─── paso 2 ───────────────────────── */}
            {step === 2 && selectedItem && (
                <div>
                    {/* Badge material seleccionado */}
                    <div className="sel-badge">
                        <span style={{ fontSize: 22 }}>{CAT_META[selectedCategory ?? '']?.emoji}</span>
                        <div>
                            <div className="sel-badge-name">{selectedItem.name}</div>
                            <div className="sel-badge-sub">{selectedItem.points} pts por unidad</div>
                        </div>
                        <button className="boton-change" onClick={() => setStep(1)}>Cambiar →</button>
                    </div>

                    <p style={{ fontSize: 13, fontWeight: 600, color: '#6b7c6d', marginBottom: '0.75rem' }}>
                        📍 Puntos que aceptan {CAT_META[selectedCategory ?? '']?.label} ({eligibleCPs.length} disponibles):
                    </p>

                    {eligibleCPs.length === 0 ? (
                        <div className="empty">
                            <span style={{ fontSize: 36 }}>😕</span>
                            <p>No hay puntos activos para esta categoría en este momento.</p>
                        </div>
                    ) : (
                        eligibleCPs.map(cp => (
                            <div
                                key={cp.id}
                                className={`puntoreciclaje-card${data.collection_point_id === cp.id ? ' sel' : ''}`}
                                onClick={() => pickCP(cp.id)}
                            >
                                <span className="puntoreciclaje-icon">📍</span>
                                <div style={{ flex: 1 }}>
                                    <div className="puntoreciclaje-name">{cp.name}</div>
                                    <div className="puntoreciclaje-addr">{cp.address}</div>
                                    {cp.schedule && <div className="puntoreciclaje-sched">⏰ {cp.schedule}</div>}
                                    {/*<div className="puntoreciclaje-cats">
                                        {(cp.accepted_categories ?? []).map(c => {
                                            const cm = CAT_META[c] ?? CAT_META.OTHER;
                                            return (
                                                <span
                                                    key={c}
                                                    className="puntoreciclaje-categoria-chip"
                                                    style={{ background: cm.bg, color: cm.color }}
                                                >
                                                    {cm.emoji} {cm.label}
                                                </span>
                                            );
                                        })}
                                    </div>*/}
                                </div>
                                {data.collection_point_id === cp.id && (
                                    <span style={{ color: '#2d6a4f', fontSize: 20, flexShrink: 0 }}>✓</span>
                                )}
                            </div>
                        ))
                    )}
                </div>
            )}

            {/* ─── paso 3 ──────────────────────────────────────── */}
            {step === 3 && selectedItem && selectedCP && (
                <div>
                    <div className="confirm-box">
                        <h2 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 20, color: '#1a3a2a', margin: '0 0 1.25rem' }}>
                            Confirma tu reciclaje
                        </h2>

                        {/* calculo puntos (falta por definir aun) */}
                        <div className="pts-preview">
                            <span style={{ fontSize: 22 }}>⭐</span>
                            Ganarás <strong style={{ marginLeft: 4 }}>{estimatedPts} puntos</strong> con esta acción
                        </div>

                        {/* cantidad */}
                        <label className="formulario-lbl">Cantidad (unidades)</label>
                        <div className="qty-row">
                            <button
                                type="button"
                                className="qty-boton"
                                onClick={() => setData('quantity', Math.max(1, data.quantity - 1))}
                            >−</button>
                            <span className="qty-num">{data.quantity}</span>
                            <button
                                type="button"
                                className="qty-boton"
                                onClick={() => setData('quantity', Math.min(999, data.quantity + 1))}
                            >+</button>
                            <span style={{ fontSize: 13, color: '#6b7c6d' }}>
                                = <strong style={{ color: '#2d6a4f' }}>{estimatedPts} pts</strong>
                            </span>
                        </div>
                        {errors.quantity && <p className="field-err">{errors.quantity}</p>}

                        {/* fecha */}
                        <label className="formulario-lbl">Fecha del reciclaje</label>
                        <input
                            type="date"
                            className="date-input"
                            value={data.date}
                            max={new Date().toISOString().split('T')[0]}
                            onChange={e => setData('date', e.target.value)}
                        />
                        {errors.date && <p className="field-err">{errors.date}</p>}

                        {/* resumen de todo (aun queda por definr aun) */}
                        <div style={{ background: '#f9faf8', borderRadius: 10, padding: '1rem', marginBottom: '1.25rem' }}>
                            {[
                                { label: 'Material',          value: selectedItem.name },
                                { label: 'Categoría',         value: `${CAT_META[selectedCategory ?? '']?.emoji} ${CAT_META[selectedCategory ?? '']?.label}` },
                                { label: 'Punto de recogida', value: selectedCP.name },
                                { label: 'Dirección',         value: selectedCP.address },
                                { label: 'Cantidad',          value: `${data.quantity} unidades` },
                                { label: 'Puntos a ganar',    value: `${estimatedPts} pts` },
                            ].map(r => (
                                <div key={r.label} className="summary-row">
                                    <span style={{ color: '#6b7c6d' }}>{r.label}</span>
                                    <span style={{ fontWeight: 500, color: '#1a3a2a', textAlign: 'right', maxWidth: '55%' }}>{r.value}</span>
                                </div>
                            ))}
                        </div>

                        {/* excepciones (falta retocar) */}
                        {errors.waste_item_id       && <p className="field-err">{errors.waste_item_id}</p>}
                        {errors.collection_point_id && <p className="field-err">{errors.collection_point_id}</p>}

                        
                        <div style={{ display: 'flex', gap: 10 }}>
                            <button type="button" className="boton-back" onClick={() => setStep(2)}>
                                ← Atrás
                            </button>
                            <button
                                className="boton-submit"
                                style={{ flex: 2 }}
                                disabled={processing}
                                onClick={() => post(route('recycle.store'))}
                            >
                                {processing ? (
                                    <>
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{ animation: 'spin 1s linear infinite' }}>
                                            <path d="M21 12a9 9 0 11-6.219-8.56" />
                                        </svg>
                                        Registrando...
                                    </>
                                ) : '✅ Confirmar reciclaje'}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
