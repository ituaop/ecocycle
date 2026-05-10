import { Head, Link } from '@inertiajs/react';
import { useEffect, useRef, useState } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { PageProps } from '@/types';

interface CollectionPoint {
    id: string;
    name: string;
    address: string;
    latitude: number;
    longitude: number;
    status: string;
    schedule: string | null;
    accepted_categories: string[];
}

interface Props extends PageProps {
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

const STATUS_META: Record<string, { label: string; color: string; bg: string; dot: string }> = {
    ACTIVE:   { label: 'Activo',   color: '#15803d', bg: '#f0fdf4', dot: '#22c55e' },
    INACTIVE: { label: 'Inactivo', color: '#71717a', bg: '#f4f4f5', dot: '#a1a1aa' },
    FULL:     { label: 'Lleno',    color: '#c2410c', bg: '#fff7ed', dot: '#f97316' },
};

// marcadores de punto de recogida (activo, inactivo, lleno)
const MARKER_COLORS: Record<string, string> = {
    ACTIVE:   '#22c55e',
    INACTIVE: '#a1a1aa',
    FULL:     '#f97316',
};

export default function CollectionPointsIndex({ collectionPoints }: Props) {
    const mapRef        = useRef<HTMLDivElement>(null);
    const leafletMapRef = useRef<any>(null);
    const markersRef    = useRef<Record<string, any>>({});

    const [selected,    setSelected]    = useState<CollectionPoint | null>(null);
    const [search,      setSearch]      = useState('');
    const [filterStatus, setFilterStatus] = useState('ALL');
    const [filterCat,   setFilterCat]   = useState('ALL');
    const [leafletReady, setLeafletReady] = useState(false);

    const allCategories = Array.from(
        new Set(collectionPoints.flatMap(cp => cp.accepted_categories ?? []))
    ).sort();

    const filtered = collectionPoints.filter(cp => {
        const matchSearch = search === '' ||
            cp.name.toLowerCase().includes(search.toLowerCase()) ||
            cp.address.toLowerCase().includes(search.toLowerCase());
        const matchStatus = filterStatus === 'ALL' || cp.status === filterStatus;
        const matchCat    = filterCat === 'ALL' || (cp.accepted_categories ?? []).includes(filterCat);
        return matchSearch && matchStatus && matchCat;
    });

    // leaflet
    useEffect(() => {
        if ((window as any).L) { setLeafletReady(true); return; }

        const link = document.createElement('link');
        link.rel  = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css';
        document.head.appendChild(link);

        const script    = document.createElement('script');
        script.src      = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js';
        script.onload   = () => setLeafletReady(true);
        document.body.appendChild(script);
    }, []);

    //mapa reactivo
    useEffect(() => {
        if (!leafletReady || !mapRef.current || leafletMapRef.current) return;

        const L   = (window as any).L;
        const map = L.map(mapRef.current, { zoomControl: true });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 19,
        }).addTo(map);

        leafletMapRef.current = map;

        // añadir puntos de recogida basando en coordenadas
        collectionPoints.forEach(cp => addMarker(cp, L, map));


        if (collectionPoints.length > 0) {
            const bounds = L.latLngBounds(
                collectionPoints.map(cp => [cp.latitude, cp.longitude])
            );
            map.fitBounds(bounds, { padding: [40, 40] });
        } else {
            map.setView([39.47, -0.376], 12); // fijar mapa en valencia usando sus coordebadas
        }

        return () => {
            map.remove();
            leafletMapRef.current = null;
            markersRef.current    = {};
        };
    }, [leafletReady]);

    function addMarker(cp: CollectionPoint, L: any, map: any) {
        const color = MARKER_COLORS[cp.status] ?? MARKER_COLORS.INACTIVE;

        const svg = `
            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="44" viewBox="0 0 34 44">
                <path d="M17 0C7.6 0 0 7.6 0 17c0 13 17 27 17 27S34 30 34 17C34 7.6 26.4 0 17 0z" fill="${color}" stroke="white" stroke-width="2"/>
                <circle cx="17" cy="17" r="7" fill="white"/>
            </svg>`;

        const icon = L.divIcon({
            html:      svg,
            iconSize:  [34, 44],
            iconAnchor:[17, 44],
            className: '',
        });

        const marker = L.marker([cp.latitude, cp.longitude], { icon })
            .addTo(map)
            .on('click', () => setSelected(cp));

        const cats = (cp.accepted_categories ?? [])
            .map(c => CAT_META[c]?.emoji ?? '♻️')
            .join(' ');

        marker.bindTooltip(
            `<strong style="font-family:'DM Sans',sans-serif">${cp.name}</strong><br/><span style="font-size:11px;color:#6b7c6d">${cp.address}</span><br/><span style="font-size:12px">${cats}</span>`,
            { direction: 'top', offset: [0, -40] }
        );

        markersRef.current[cp.id] = marker;
    }

    // uso de filtros en el mapa + marcadores recativos
    useEffect(() => {
        if (!leafletMapRef.current) return;
        const filteredIds = new Set(filtered.map(cp => cp.id));
        Object.entries(markersRef.current).forEach(([id, marker]) => {
            const map = leafletMapRef.current;
            if (filteredIds.has(id)) {
                if (!map.hasLayer(marker)) marker.addTo(map);
            } else {
                if (map.hasLayer(marker)) map.removeLayer(marker);
            }
        });
    }, [filtered.length, filterStatus, filterCat, search]);

    function selectPoint(cp: CollectionPoint) {
        setSelected(cp);
        const map    = leafletMapRef.current;
        const marker = markersRef.current[cp.id];
        if (map && marker) {
            map.setView([cp.latitude, cp.longitude], 16, { animate: true });
            marker.openTooltip();
        }
    }

    const activeCount = collectionPoints.filter(cp => cp.status === 'ACTIVE').length;
// redirect a la pagina de reciclar
    return (
        <AppLayout header={
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <div>
                    <h1 style={{ fontFamily: "'DM Serif Display',serif", fontSize: 22, color: '#1a3a2a', margin: 0 }}>
                        Puntos de recogida disponibles
                    </h1>
                    
                </div>
                <Link href={route('recycle.index')} style={{ display: 'flex', alignItems: 'center', gap: 7, background: '#1a3a2a', color: '#fff', padding: '9px 18px', borderRadius: 10, fontSize: 14, fontWeight: 500, textDecoration: 'none', fontFamily: "'DM Sans',sans-serif" }}>
                    ♻️ Reciclar ahora 
                </Link> 
            </div>
        }>
            <Head title="Puntos de recogida" />

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
                body, * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }

                .puntoreciclaje-layout { display: grid; grid-template-columns: 340px 1fr; gap: 1.25rem; align-items: start; }
                @media(max-width: 900px) { .puntoreciclaje-layout { grid-template-columns: 1fr; } .map-col { order: -1; } }

                /* barra busqueda y filtros */
                .search-bar { display: flex; align-items: center; gap: 8px; background: #fff; border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 0 12px; height: 42px; margin-bottom: 10px; transition: border-color 0.2s; }
                .search-bar:focus-within { border-color: #2d6a4f; }
                .search-bar input { flex: 1; border: none; outline: none; font-size: 14px; color: #1c1c1c; background: transparent; font-family: 'DM Sans', sans-serif; }
                .search-bar input::placeholder { color: #bbb; }
                .filter-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 10px; }
                .filter-boton { padding: 4px 11px; border-radius: 20px; border: 1.5px solid #e0e0e0; background: #fff; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif; color: #6b7c6d; white-space: nowrap; }
                .filter-boton:hover { border-color: #2d6a4f; color: #2d6a4f; }
                .filter-boton.on { background: #1a3a2a; color: #fff; border-color: #1a3a2a; }

                /* lista */
                .puntoreciclaje-list { display: flex; flex-direction: column; gap: 7px; max-height: calc(100vh - 260px); overflow-y: auto; padding-right: 2px; }
                .puntoreciclaje-list::-webkit-scrollbar { width: 4px; }
                .puntoreciclaje-list::-webkit-scrollbar-track { background: transparent; }
                .puntoreciclaje-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 99px; }

                .puntoreciclaje-item { background: #fff; border: 2px solid #e8ebe6; border-radius: 12px; padding: 12px 14px; cursor: pointer; transition: all 0.15s; }
                .puntoreciclaje-item:hover { border-color: #52b788; transform: translateY(-1px); box-shadow: 0 3px 12px rgba(0,0,0,0.06); }
                .puntoreciclaje-item.sel { border-color: #2d6a4f; background: #f0fdf4; }
                .puntoreciclaje-item-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 4px; }
                .puntoreciclaje-name { font-size: 14px; font-weight: 600; color: #1a3a2a; line-height: 1.3; }
                .puntoreciclaje-addr { font-size: 12px; color: '#6b7c6d'; margin-bottom: 4px; display: flex; align-items: center; gap: 4px; }
                .puntoreciclaje-sched { font-size: 11px; color: #9ca3af; margin-bottom: 5px; }
                .status-pill { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; flex-shrink: 0; }
                .status-dot { width: 6px; height: 6px; border-radius: 50%; }
                .cat-chips { display: flex; flex-wrap: wrap; gap: 3px; }
                .cat-chip { font-size: 10px; font-weight: 600; padding: 1px 6px; border-radius: 7px; display: inline-flex; align-items: center; gap: 2px; }
                .no-results { padding: 2rem; text-align: center; color: #9ca3af; font-size: 14px; background: #fff; border-radius: 12px; border: 1px solid #e8ebe6; }

                /* Map column */
                .map-col { display: flex; flex-direction: column; gap: 1rem; position: sticky; top: 80px; }
                .map-wrap { border-radius: 14px; overflow: hidden; border: 1px solid #e8ebe6; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
                #puntoreciclaje-map { height: 440px; width: 100%; background: #e8f5e9; }
                .map-loading { height: 440px; display: flex; align-items: center; justify-content: center; background: #f9faf8; color: #9ca3af; font-size: 14px; gap: 8px; }
                @keyframes spin { to { transform: rotate(360deg); } }

                /* panel */
                .detalles-panel { background: #fff; border-radius: 14px; border: 1px solid #e8ebe6; overflow: hidden; transition: all 0.2s; }
                .detalles-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f0f0ee; background: linear-gradient(135deg, #1a3a2a, #2d6a4f); }
                .detalles-title { font-family: 'DM Serif Display', serif; font-size: 17px; color: #fff; margin-bottom: 3px; }
                .detalles-addr  { font-size: 13px; color: rgba(255,255,255,0.65); }
                .detalles-body  { padding: 1.1rem 1.25rem; }
                .detalles-row   { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f9faf8; }
                .detalles-row:last-child { border-bottom: none; }
                .detalles-icon  { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
                .detalles-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 2px; }
                .detalles-val   { font-size: 14px; color: #1a3a2a; font-weight: 500; }
                .detalles-cats  { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 4px; }
                .detalles-cat   { display: flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 9px; }
                .boton-recycle  { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; height: 44px; background: #1a3a2a; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 500; font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; transition: background 0.15s; margin-top: 1rem; }
                .boton-recycle:hover { background: #2d6a4f; }

               
                .legend { background: #fff; border-radius: 10px; border: 1px solid #e8ebe6; padding: 10px 14px; display: flex; gap: 14px; align-items: center; }
                .legend-item { display: flex; align-items: center; gap: 5px; font-size: 12px; color: #6b7c6d; }
                .legend-dot { width: 12px; height: 12px; border-radius: 50%; }

                .leaflet-tooltip { font-family: 'DM Sans', sans-serif !important; border-radius: 8px !important; border: 1px solid #e8ebe6 !important; box-shadow: 0 4px 16px rgba(0,0,0,0.1) !important; padding: 7px 10px !important; font-size: 13px !important; }
            `}</style>

            <div className="puntoreciclaje-layout">
                <div>
                    {/* busqueda puntos recogida */}
                    <div className="search-bar">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input
                            placeholder="Buscar por nombre o dirección..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                        />
                        {search && (
                            <button onClick={() => setSearch('')} style={{ background: 'none', border: 'none', cursor: 'pointer', color: '#9ca3af', fontSize: 16, padding: 0, lineHeight: 1 }}>×</button>
                        )}
                    </div>

                    {/* filtros panel izquierda */}
                    <div className="filter-row">
                        {[
                            { key: 'ALL',      label: `Todos (${collectionPoints.length})` },
                            { key: 'ACTIVE',   label: `Activos (${collectionPoints.filter(c=>c.status==='ACTIVE').length})` },
                            { key: 'FULL',     label: 'Llenos' },
                            { key: 'INACTIVE', label: 'Inactivos' },
                        ].map(f => (
                            <button key={f.key} className={`filter-boton${filterStatus === f.key ? ' on' : ''}`}
                                onClick={() => setFilterStatus(f.key)}>
                                {f.label}
                            </button>
                        ))}
                    </div>

                    {/* categorias */}
                    <div className="filter-row">
                        <button className={`filter-boton${filterCat === 'ALL' ? ' on' : ''}`} onClick={() => setFilterCat('ALL')}>
                            Todas las categorías
                        </button>
                        {allCategories.map(cat => {
                            const cm = CAT_META[cat] ?? CAT_META.OTHER;
                            return (
                                <button key={cat} className={`filter-boton${filterCat === cat ? ' on' : ''}`}
                                    onClick={() => setFilterCat(cat)}>
                                    {cm.emoji} {cm.label}
                                </button>
                            );
                        })}
                    </div>


                    <div style={{ fontSize: 12, color: '#9ca3af', marginBottom: 8 }}>
                        {filtered.length} resultado{filtered.length !== 1 ? 's' : ''}
                    </div>

                    <div className="puntoreciclaje-list">
                        {filtered.length === 0 ? (
                            <div className="no-results">
                                <div style={{ fontSize: 32, marginBottom: 8 }}>🔍</div>
                                No se encontraron puntos con ese filtro.
                            </div>
                        ) : (
                            filtered.map(cp => {
                                const sm = STATUS_META[cp.status] ?? STATUS_META.INACTIVE;
                                const isSel = selected?.id === cp.id;
                                return (
                                    <div key={cp.id} className={`puntoreciclaje-item${isSel ? ' sel' : ''}`} onClick={() => selectPoint(cp)}>
                                        <div className="puntoreciclaje-item-header">
                                            <span className="puntoreciclaje-name">{cp.name}</span>
                                            <span className="status-pill" style={{ background: sm.bg, color: sm.color }}>
                                                <span className="status-dot" style={{ background: sm.dot }}/>
                                                {sm.label}
                                            </span>
                                        </div>
                                        <div className="puntoreciclaje-addr" style={{ color: '#6b7c6d' }}>
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{ flexShrink: 0 }}><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                            {cp.address}
                                        </div>

                                        <div className="cat-chips">
                                            {(cp.accepted_categories ?? []).map(c => {
                                                const cm = CAT_META[c] ?? CAT_META.OTHER;
                                                return (
                                                    <span key={c} className="cat-chip" style={{ background: cm.bg, color: cm.color }}>
                                                        {cm.emoji} {cm.label}
                                                    </span>
                                                );
                                            })}
                                        </div>
                                    </div>
                                );
                            })
                        )}
                    </div>
                </div>

                {/* parte derecha: mapa reactivo */}
                
                <div className="map-col">
                     <div className="legend">
                        <span style={{ fontSize: 12, fontWeight: 600, color: '#6b7c6d', marginRight: 4 }}>Leyenda:</span>
                        {Object.entries(STATUS_META).map(([key, sm]) => (
                            <div key={key} className="legend-item">
                                <div className="legend-dot" style={{ background: MARKER_COLORS[key] }}/>
                                {sm.label}
                            </div>
                        ))}
                    </div>
                    <div className="map-wrap">
                        {!leafletReady ? (
                            <div className="map-loading">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#52b788" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{ animation: 'spin 1s linear infinite' }}>
                                    <path d="M21 12a9 9 0 11-6.219-8.56"/>
                                </svg>
                                Cargando mapa...
                            </div>
                        ) : (
                            <div id="puntoreciclaje-map" ref={mapRef} />
                        )}
                    </div>

                   

                    {selected ? (
                        <div className="detalles-panel">
                            <div className="detalles-header">
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start' }}>
                                    <div>
                                        <div className="detalles-title">{selected.name}</div>
                                        <div className="detalles-addr">{selected.address}</div>
                                    </div>
                                    {(() => {
                                        const sm = STATUS_META[selected.status] ?? STATUS_META.INACTIVE;
                                        return (
                                            <span style={{ display: 'inline-flex', alignItems: 'center', gap: 5, background: 'rgba(255,255,255,0.15)', padding: '3px 10px', borderRadius: 20, fontSize: 12, color: '#fff', fontWeight: 600, flexShrink: 0 }}>
                                                <span style={{ width: 7, height: 7, borderRadius: '50%', background: sm.dot, display: 'inline-block' }}/>
                                                {sm.label}
                                            </span>
                                        );
                                    })()}
                                </div>
                            </div>
                            <div className="detalles-body">
                                {selected.schedule && (
                                    <div className="detalles-row">
                                        <span className="detalles-icon">⏰</span>
                                        <div>
                                            <div className="detalles-label">Horario</div>
                                            <div className="detalles-val">{selected.schedule}</div>
                                        </div>
                                    </div>
                                )}
                                <div className="detalles-row">
                                    <span className="detalles-icon">🗺️</span>
                                    <div>
                                        <div className="detalles-label">Coordenadas</div>
                                        <div className="detalles-val" style={{ fontSize: 13, color: '#6b7c6d' }}>
                                            {selected.latitude.toFixed(5)}, {selected.longitude.toFixed(5)}
                                        </div>
                                        <a
                                            href={`https://maps.google.com/?q=${selected.latitude},${selected.longitude}`}
                                            target="_blank"
                                            rel="noreferrer"
                                            style={{ fontSize: 12, color: '#2d6a4f', fontWeight: 500, textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: 3, marginTop: 3 }}
                                        >
                                            Abrir en Google Maps →
                                        </a>
                                    </div>
                                </div>
                                <div className="detalles-row">
                                    <span className="detalles-icon">✅</span>
                                    <div style={{ flex: 1 }}>
                                        <div className="detalles-label">Acepta</div>
                                        <div className="detalles-cats">
                                            {(selected.accepted_categories ?? []).map(c => {
                                                const cm = CAT_META[c] ?? CAT_META.OTHER;
                                                return (
                                                    <span key={c} className="detalles-cat" style={{ background: cm.bg, color: cm.color }}>
                                                        {cm.emoji} {cm.label}
                                                    </span>
                                                );
                                            })}
                                        </div>
                                    </div>
                                </div>

                                {/*{selected.status === 'ACTIVE' && (
                                    <Link href={route('recycle.index')} className="boton-recycle">
                                        ♻️ Reciclar en este punto
                                    </Link>
                                )}*/}
                                {selected.status === 'FULL' && (
                                    <div style={{ marginTop: '0.75rem', background: '#fff7ed', border: '1px solid #fed7aa', borderRadius: 9, padding: '9px 12px', fontSize: 13, color: '#c2410c' }}>
                                        ⚠️ Este punto está lleno. Prueba otro punto cercano.
                                    </div>
                                )}
                                {selected.status === 'INACTIVE' && (
                                    <div style={{ marginTop: '0.75rem', background: '#f4f4f5', border: '1px solid #d4d4d8', borderRadius: 9, padding: '9px 12px', fontSize: 13, color: '#71717a' }}>
                                        ℹ️ Este punto está temporalmente inactivo.
                                    </div>
                                )}
                            </div>
                        </div>
                    ) : (
                        <div style={{ background: '#fff', borderRadius: 14, border: '1px solid #e8ebe6', padding: '2.5rem 1.5rem', textAlign: 'center' }}>
                            <p style={{ fontSize: 14, color: '#9ca3af', margin: 0, lineHeight: 1.6 }}>
                                Selecciona un punto de la lista<br/>o haz clic en un marcador del mapa
                            </p>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}