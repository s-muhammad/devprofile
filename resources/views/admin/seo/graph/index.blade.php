@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6 pb-4 border-b border-gray-200">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    <i class="fas fa-search text-blue-600 ml-3"></i>
                    دفترچه سئو
                </h2>
                <p class="text-xs text-gray-500 mt-2">
                    نقشه ارتباط کلمات کلیدی و کارهای سئو؛ روی هر کلمه کلیک کنید تا بریف آن را ببینید.
                </p>
            </div>
        </div>

        @include('admin.seo.partials.tabs')

        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">کلمات در گراف</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['keywords']) }}</p>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                    <i class="fas fa-key text-lg"></i>
                </span>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">ارتباط‌ها</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['links']) }}</p>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center">
                    <i class="fas fa-link text-lg"></i>
                </span>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">میانگین اولویت کارها</p>
                    <p class="text-2xl font-extrabold text-gray-800">
                        {{ $stats['avg_priority'] !== null ? number_format($stats['avg_priority'], 1) : '-' }}
                    </p>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center">
                    <i class="fas fa-star text-lg"></i>
                </span>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">منتشرشده</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['published']) }}</p>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center">
                    <i class="fas fa-circle-check text-lg"></i>
                </span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row-reverse items-start gap-6">
            {{-- بریف کلمه --}}
            <aside id="seo-brief-card"
                   class="w-full lg:w-80 xl:w-96 shrink-0 bg-white rounded-2xl shadow-xl p-6 lg:sticky lg:top-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <i class="fas fa-file-lines"></i>
                    </span>
                    <h3 class="font-extrabold text-gray-800">بریف کلمه</h3>
                </div>

                <div id="seo-brief-content">
                    <div class="text-center py-10 text-gray-400">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mb-4">
                            <i class="fas fa-file-lines text-2xl"></i>
                        </div>
                        <p class="font-semibold text-gray-600 mb-2">بریف کلمه</p>
                        <p class="text-xs leading-6">
                            روی یکی از کلمات در گراف کلیک کنید تا نقش، صفحه هدف، لینک‌های داخلی و کارهای مرتبط آن را ببینید.
                        </p>
                    </div>
                </div>
            </aside>

            {{-- گراف --}}
            <section class="w-full flex-1 min-w-0 bg-white rounded-2xl shadow-xl p-4 md:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">گراف کلمات کلیدی</h3>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ number_format($stats['keywords']) }} کلمه ·
                            {{ number_format($stats['tasks']) }} کار ·
                            {{ number_format($stats['links']) }} ارتباط
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <label class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 cursor-pointer">
                            <input type="checkbox" id="seo-toggle-edges" checked
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            ارتباطات
                        </label>
                        <label class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 cursor-pointer">
                            <input type="checkbox" id="seo-toggle-labels" checked
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            برچسب‌ها
                        </label>

                        <button type="button" id="seo-relayout"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200
                                       border border-gray-200 rounded-lg px-3 py-2 transition">
                            <i class="fas fa-shuffle"></i>
                            بازچینش
                        </button>

                        <div class="inline-flex items-center rounded-lg border border-gray-200 bg-white overflow-hidden">
                            <button type="button" id="seo-zoom-out" title="کوچک‌نمایی"
                                    class="w-9 h-9 text-lg text-gray-600 hover:bg-gray-100 transition">−</button>
                            <span class="w-px h-5 bg-gray-200"></span>
                            <button type="button" id="seo-zoom-in" title="بزرگ‌نمایی"
                                    class="w-9 h-9 text-lg text-gray-600 hover:bg-gray-100 transition">+</button>
                        </div>
                    </div>
                </div>

                <div id="seo-graph-wrap"
                     class="relative w-full rounded-xl border border-gray-100 bg-gradient-to-br from-slate-50 via-white to-amber-50/40 overflow-hidden"
                     style="height: 620px;">
                    <svg id="seo-graph" class="w-full h-full block" xmlns="http://www.w3.org/2000/svg"></svg>
                    <div id="seo-graph-empty" class="hidden absolute inset-0 flex flex-col items-center justify-center text-gray-500">
                        <i class="fas fa-project-diagram text-4xl text-gray-300 mb-3"></i>
                        <p class="font-semibold">هنوز داده‌ای برای نمایش در گراف وجود ندارد.</p>
                        <p class="text-sm mt-1">ابتدا کلمه کلیدی و کار اضافه کنید.</p>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-[11px] text-gray-500 bg-gray-50 rounded-xl px-4 py-2.5">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-amber-400 ring-2 ring-amber-200"></span>
                        کلمه کلیدی
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                        انجام نشده
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        در حال انجام
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-600"></span>
                        انجام شده
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="h-px w-5 bg-slate-300"></span>
                        ارتباط
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fas fa-circle text-[8px] text-gray-300"></i>
                        اندازه گره = تعداد کارها
                    </span>
                </div>
            </section>
        </div>
    </main>

    <script>
        (function () {
            const svg = document.getElementById('seo-graph');
            const emptyState = document.getElementById('seo-graph-empty');
            const briefCard = document.getElementById('seo-brief-card');
            const briefContent = document.getElementById('seo-brief-content');
            const briefPlaceholder = briefContent.innerHTML;
            const edgesToggle = document.getElementById('seo-toggle-edges');
            const labelsToggle = document.getElementById('seo-toggle-labels');
            const relayoutButton = document.getElementById('seo-relayout');
            const zoomInButton = document.getElementById('seo-zoom-in');
            const zoomOutButton = document.getElementById('seo-zoom-out');

            const rawNodes = @json($nodes, JSON_UNESCAPED_UNICODE);
            const rawLinks = @json($edges, JSON_UNESCAPED_UNICODE);
            const briefs = @json($briefs, JSON_UNESCAPED_UNICODE);

            if (!rawNodes.length) {
                emptyState.classList.remove('hidden');
                return;
            }

            const NS = 'http://www.w3.org/2000/svg';
            const width = 1000;
            const height = 620;
            const keywordColor = '#fbbf24';
            const keywordStroke = '#d97706';
            const statusColors = {
                todo: '#94a3b8',
                in_progress: '#f59e0b',
                done: '#16a34a',
            };
            const statusBadgeClasses = {
                todo: 'bg-slate-100 text-slate-600',
                in_progress: 'bg-amber-100 text-amber-700',
                done: 'bg-green-100 text-green-700',
            };

            svg.setAttribute('viewBox', '0 0 ' + width + ' ' + height);
            svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');

            const nodes = rawNodes.map(function (node, index) {
                const angle = (index / rawNodes.length) * Math.PI * 2;
                const radius = 120 + (index % 5) * 55;

                return Object.assign({}, node, {
                    x: width / 2 + Math.cos(angle) * radius,
                    y: height / 2 + Math.sin(angle) * radius,
                    vx: 0,
                    vy: 0,
                });
            });

            const nodeById = new Map(nodes.map(function (node) {
                return [node.id, node];
            }));

            const links = rawLinks
                .map(function (link) {
                    return {
                        source: nodeById.get(link.source),
                        target: nodeById.get(link.target),
                    };
                })
                .filter(function (link) {
                    return link.source && link.target;
                });

            const root = document.createElementNS(NS, 'g');
            const linkLayer = document.createElementNS(NS, 'g');
            const nodeLayer = document.createElementNS(NS, 'g');
            root.append(linkLayer, nodeLayer);
            svg.appendChild(root);

            const linkElements = links.map(function (link) {
                const line = document.createElementNS(NS, 'line');
                line.setAttribute('stroke', '#dbe3ec');
                line.setAttribute('stroke-width', '1.2');
                linkLayer.appendChild(line);

                return line;
            });

            const hideTaskLabels = nodes.length > 45;
            let labelsVisible = true;
            let zoom = 1;

            const nodeElements = nodes.map(function (node) {
                const group = document.createElementNS(NS, 'g');
                group.setAttribute('class', 'seo-graph-node');
                group.setAttribute('data-node-id', node.id);
                group.style.cursor = 'grab';

                const isKeyword = node.type === 'keyword';
                const radius = Number(node.radius) || (isKeyword ? 17 : 9);
                const color = isKeyword ? keywordColor : (statusColors[node.status] || statusColors.todo);

                const circle = document.createElementNS(NS, 'circle');
                circle.setAttribute('r', String(radius));
                circle.setAttribute('fill', color);
                circle.setAttribute('stroke', isKeyword ? keywordStroke : '#ffffff');
                circle.setAttribute('stroke-width', '2');
                circle.style.filter = 'drop-shadow(0 1px 2px rgba(15, 23, 42, 0.22))';
                group.appendChild(circle);

                const title = document.createElementNS(NS, 'title');
                title.textContent = node.tooltip || node.label;
                circle.appendChild(title);

                const label = document.createElementNS(NS, 'text');
                label.textContent = node.label.length > 28 ? node.label.slice(0, 27) + '…' : node.label;
                label.setAttribute('text-anchor', 'middle');
                label.setAttribute('y', String(radius + 14));
                label.setAttribute('font-size', isKeyword ? '12' : '10');
                label.setAttribute('font-family', 'Vazirmatn, sans-serif');
                label.setAttribute('fill', isKeyword ? '#92400e' : '#475569');
                label.style.pointerEvents = 'none';

                if (isKeyword) {
                    label.setAttribute('font-weight', '700');
                }

                if (!isKeyword && hideTaskLabels) {
                    label.style.opacity = '0';
                }

                group.appendChild(label);
                nodeLayer.appendChild(group);

                group.addEventListener('mouseenter', function () {
                    label.style.opacity = '1';
                    nodeLayer.appendChild(group);
                    highlightLinks(node.id);
                });

                group.addEventListener('mouseleave', function () {
                    if (!isKeyword && hideTaskLabels && labelsVisible) {
                        label.style.opacity = '0';
                    }

                    highlightLinks(selectedId);
                });

                return { group: group, node: node, label: label, circle: circle };
            });

            let alpha = 1;
            let running = false;
            let draggedNode = null;
            let dragOffsetX = 0;
            let dragOffsetY = 0;
            let dragStartX = 0;
            let dragStartY = 0;
            let movedWhileDragging = false;
            let selectedId = null;

            function startSimulation() {
                if (running) {
                    return;
                }

                running = true;
                requestAnimationFrame(step);
            }

            function step() {
                for (let i = 0; i < nodes.length; i++) {
                    const a = nodes[i];

                    for (let j = i + 1; j < nodes.length; j++) {
                        const b = nodes[j];
                        let dx = b.x - a.x;
                        let dy = b.y - a.y;
                        let distanceSquared = dx * dx + dy * dy;

                        if (distanceSquared < 1) {
                            dx = (Math.random() - 0.5) * 2;
                            dy = (Math.random() - 0.5) * 2;
                            distanceSquared = dx * dx + dy * dy;
                        }

                        const distance = Math.sqrt(distanceSquared);
                        const strength = (a.type === 'keyword' || b.type === 'keyword') ? 3000 : 1100;
                        const force = (strength / distanceSquared) * alpha;
                        const fx = (dx / distance) * force;
                        const fy = (dy / distance) * force;

                        a.vx -= fx;
                        a.vy -= fy;
                        b.vx += fx;
                        b.vy += fy;
                    }
                }

                links.forEach(function (link) {
                    const a = link.source;
                    const b = link.target;
                    const dx = b.x - a.x;
                    const dy = b.y - a.y;
                    const distance = Math.hypot(dx, dy) || 0.01;
                    const restLength = a.type === 'keyword' && b.type === 'keyword' ? 140 : 110;
                    const force = (distance - restLength) * 0.02 * alpha;
                    const fx = (dx / distance) * force;
                    const fy = (dy / distance) * force;

                    a.vx += fx;
                    a.vy += fy;
                    b.vx -= fx;
                    b.vy -= fy;
                });

                nodes.forEach(function (node) {
                    node.vx += (width / 2 - node.x) * 0.0015 * alpha;
                    node.vy += (height / 2 - node.y) * 0.0015 * alpha;
                    node.vx *= 0.85;
                    node.vy *= 0.85;

                    const speed = Math.hypot(node.vx, node.vy);

                    if (speed > 12) {
                        node.vx = (node.vx / speed) * 12;
                        node.vy = (node.vy / speed) * 12;
                    }

                    if (draggedNode !== node) {
                        node.x += node.vx;
                        node.y += node.vy;
                    }

                    const pad = 50;
                    node.x = Math.max(pad, Math.min(width - pad, node.x));
                    node.y = Math.max(pad + 20, Math.min(height - pad, node.y));
                });

                alpha *= 0.987;
                render();

                if (draggedNode || alpha > 0.02) {
                    requestAnimationFrame(step);
                } else {
                    running = false;
                }
            }

            function render() {
                linkElements.forEach(function (line, index) {
                    const link = links[index];
                    line.setAttribute('x1', String(link.source.x));
                    line.setAttribute('y1', String(link.source.y));
                    line.setAttribute('x2', String(link.target.x));
                    line.setAttribute('y2', String(link.target.y));
                });

                nodeElements.forEach(function (element) {
                    element.group.setAttribute(
                        'transform',
                        'translate(' + element.node.x + ', ' + element.node.y + ')'
                    );
                });
            }

            function applyZoom() {
                const center = width / 2;
                const centerY = height / 2;
                const translateX = center - center * zoom;
                const translateY = centerY - centerY * zoom;
                root.setAttribute('transform', 'translate(' + translateX + ' ' + translateY + ') scale(' + zoom + ')');
            }

            function toRootPoint(event) {
                const point = svg.createSVGPoint();
                point.x = event.clientX;
                point.y = event.clientY;

                return point.matrixTransform(root.getScreenCTM().inverse());
            }

            function highlightLinks(nodeId) {
                linkElements.forEach(function (line, index) {
                    const link = links[index];

                    if (!nodeId) {
                        line.setAttribute('stroke', '#dbe3ec');
                        line.setAttribute('stroke-width', '1.2');
                        line.setAttribute('opacity', '1');

                        return;
                    }

                    const connected = link.source.id === nodeId || link.target.id === nodeId;
                    line.setAttribute('stroke', connected ? '#f59e0b' : '#e2e8f0');
                    line.setAttribute('stroke-width', connected ? '2.4' : '1.2');
                    line.setAttribute('opacity', connected ? '1' : '0.3');
                });
            }

            function selectNode(node) {
                selectedId = node.id;

                nodeElements.forEach(function (element) {
                    const isSelected = element.node.id === node.id;
                    const isKeyword = element.node.type === 'keyword';

                    element.circle.setAttribute('stroke', isSelected ? '#0f172a' : (isKeyword ? keywordStroke : '#ffffff'));
                    element.circle.setAttribute('stroke-width', isSelected ? '4' : '2');

                    if (isSelected) {
                        nodeLayer.appendChild(element.group);
                    }
                });

                renderBrief(node.id);
                highlightLinks(node.id);

                if (window.innerWidth < 1024) {
                    briefCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function (character) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;',
                    }[character];
                });
            }

            function infoBox(label, value) {
                return '<div class="rounded-xl bg-gray-50 px-3 py-2">'
                    + '<p class="text-[10px] text-gray-400 mb-0.5">' + escapeHtml(label) + '</p>'
                    + '<p class="text-sm font-bold text-gray-700">' + escapeHtml(value) + '</p>'
                    + '</div>';
            }

            function section(title, content) {
                return '<div class="mb-5">'
                    + '<p class="text-[11px] font-bold text-gray-400 mb-2">' + escapeHtml(title) + '</p>'
                    + content
                    + '</div>';
            }

            function statusBadge(status, label) {
                const classes = statusBadgeClasses[status] || 'bg-blue-100 text-blue-700';

                return '<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-bold '
                    + classes + '">' + escapeHtml(label) + '</span>';
            }

            function keywordBrief(data) {
                const tasks = data.tasks || [];
                const internalLinks = data.internalLinks || [];

                const tasksHtml = tasks.length
                    ? tasks.map(function (task) {
                        return '<li class="rounded-xl border border-gray-100 bg-gray-50 p-3 mb-2">'
                            + '<div class="flex items-start justify-between gap-2">'
                            + '<p class="text-sm font-semibold text-gray-700 leading-6">' + escapeHtml(task.title) + '</p>'
                            + statusBadge(task.status, task.statusLabel)
                            + '</div>'
                            + '<p class="text-[11px] text-gray-500 mt-1">اولویت: ' + escapeHtml(task.priorityLabel)
                            + (task.dueDate ? ' · سررسید: ' + escapeHtml(task.dueDate) : '') + '</p>'
                            + (task.relatedUrl ? '<p class="text-[11px] text-blue-600 dir-ltr text-left truncate mt-1">' + escapeHtml(task.relatedUrl) + '</p>' : '')
                            + '</li>';
                    }).join('')
                    : '<p class="text-xs text-gray-400">کاری برای این کلمه ثبت نشده است.</p>';

                const linksHtml = internalLinks.length
                    ? internalLinks.map(function (url) {
                        return '<li class="text-xs text-blue-700 dir-ltr text-left truncate mb-1">' + escapeHtml(url) + '</li>';
                    }).join('')
                    : '<p class="text-xs text-gray-400">لینکی ثبت نشده است.</p>';

                return '<div class="flex items-start justify-between gap-3 mb-5">'
                    + '<div>'
                    + '<p class="text-[11px] font-bold text-amber-600 mb-1">بریف کلمه کلیدی</p>'
                    + '<h4 class="text-lg font-extrabold text-gray-800 leading-7">' + escapeHtml(data.title) + '</h4>'
                    + '</div>'
                    + statusBadge(data.status, data.statusLabel)
                    + '</div>'
                    + '<div class="grid grid-cols-2 gap-3 mb-5">'
                    + infoBox('نقش', data.intentLabel || '-')
                    + infoBox('حجم جستجو', data.searchVolume ?? '-')
                    + infoBox('سختی', data.difficultyLabel || '-')
                    + infoBox('رتبه فعلی', data.rank ?? '-')
                    + '</div>'
                    + section('صفحه هدف', data.targetUrl
                        ? '<p class="dir-ltr text-left text-sm text-blue-700 break-all">' + escapeHtml(data.targetUrl) + '</p>'
                        : '<p class="text-xs text-gray-400">تعیین نشده</p>')
                    + (data.notes
                        ? section('بریف / یادداشت', '<p class="text-sm text-gray-700 leading-6 whitespace-pre-line">' + escapeHtml(data.notes) + '</p>')
                        : '')
                    + section('کارهای مرتبط (' + tasks.length + ')',
                        '<ul class="max-h-64 overflow-y-auto pl-1">' + tasksHtml + '</ul>')
                    + section('لینک‌های داخلی', '<ul>' + linksHtml + '</ul>');
            }

            function taskBrief(data) {
                return '<div class="flex items-start justify-between gap-3 mb-5">'
                    + '<div>'
                    + '<p class="text-[11px] font-bold text-amber-600 mb-1">بریف کار</p>'
                    + '<h4 class="text-lg font-extrabold text-gray-800 leading-7">' + escapeHtml(data.title) + '</h4>'
                    + '</div>'
                    + statusBadge(data.status, data.statusLabel)
                    + '</div>'
                    + '<div class="grid grid-cols-2 gap-3 mb-5">'
                    + infoBox('اولویت', data.priorityLabel)
                    + infoBox('سررسید', data.dueDate || '-')
                    + '</div>'
                    + section('کلمه کلیدی مرتبط', data.keywordTitle
                        ? '<button type="button" data-select-node="' + escapeHtml(data.keywordId) + '" class="text-sm font-bold text-blue-700 hover:text-blue-900 transition">' + escapeHtml(data.keywordTitle) + '</button>'
                        : '<p class="text-xs text-gray-400">بدون کلمه کلیدی</p>')
                    + section('آدرس مرتبط', data.relatedUrl
                        ? '<p class="dir-ltr text-left text-sm text-blue-700 break-all">' + escapeHtml(data.relatedUrl) + '</p>'
                        : '<p class="text-xs text-gray-400">تعیین نشده</p>')
                    + (data.description
                        ? section('توضیحات', '<p class="text-sm text-gray-700 leading-6 whitespace-pre-line">' + escapeHtml(data.description) + '</p>')
                        : '');
            }

            function renderBrief(nodeId) {
                const data = briefs[nodeId];

                if (!data) {
                    briefContent.innerHTML = briefPlaceholder;

                    return;
                }

                briefContent.innerHTML = data.type === 'keyword' ? keywordBrief(data) : taskBrief(data);

                briefContent.querySelectorAll('[data-select-node]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const target = nodeById.get(button.getAttribute('data-select-node'));

                        if (target) {
                            selectNode(target);
                        }
                    });
                });
            }

            function relayout() {
                nodes.forEach(function (node, index) {
                    const angle = (index / nodes.length) * Math.PI * 2 + Math.random() * 0.4;
                    const radius = 100 + Math.random() * 180;

                    node.x = width / 2 + Math.cos(angle) * radius;
                    node.y = height / 2 + Math.sin(angle) * radius;
                    node.vx = 0;
                    node.vy = 0;
                });

                alpha = 1;
                startSimulation();
                render();
            }

            svg.addEventListener('pointerdown', function (event) {
                const group = event.target.closest('.seo-graph-node');

                if (!group) {
                    return;
                }

                const node = nodeById.get(group.getAttribute('data-node-id'));

                if (!node) {
                    return;
                }

                const point = toRootPoint(event);
                draggedNode = node;
                dragOffsetX = node.x - point.x;
                dragOffsetY = node.y - point.y;
                dragStartX = point.x;
                dragStartY = point.y;
                movedWhileDragging = false;
                node.vx = 0;
                node.vy = 0;
                group.style.cursor = 'grabbing';
                svg.setPointerCapture(event.pointerId);
                alpha = Math.max(alpha, 0.3);
                startSimulation();
                event.preventDefault();
            });

            svg.addEventListener('pointermove', function (event) {
                if (!draggedNode) {
                    return;
                }

                const point = toRootPoint(event);

                if (Math.hypot(point.x - dragStartX, point.y - dragStartY) > 4) {
                    movedWhileDragging = true;
                }

                draggedNode.x = Math.max(45, Math.min(width - 45, point.x + dragOffsetX));
                draggedNode.y = Math.max(60, Math.min(height - 45, point.y + dragOffsetY));
                draggedNode.vx = 0;
                draggedNode.vy = 0;
                render();
            });

            function endDrag(event) {
                if (!draggedNode) {
                    return;
                }

                const clickedNode = draggedNode;

                nodeElements.forEach(function (element) {
                    if (element.node === draggedNode) {
                        element.group.style.cursor = 'grab';
                    }
                });

                draggedNode = null;

                if (svg.hasPointerCapture(event.pointerId)) {
                    svg.releasePointerCapture(event.pointerId);
                }

                if (!movedWhileDragging) {
                    selectNode(clickedNode);
                }

                alpha = Math.max(alpha, 0.2);
                startSimulation();
            }

            svg.addEventListener('pointerup', endDrag);
            svg.addEventListener('pointercancel', endDrag);

            edgesToggle.addEventListener('change', function () {
                linkLayer.style.display = edgesToggle.checked ? '' : 'none';
            });

            labelsToggle.addEventListener('change', function () {
                labelsVisible = labelsToggle.checked;

                nodeElements.forEach(function (element) {
                    element.label.style.display = labelsVisible ? '' : 'none';

                    if (labelsVisible) {
                        element.label.style.opacity = (!element.node.type || element.node.type === 'task') && hideTaskLabels ? '0' : '1';
                    }
                });
            });

            relayoutButton.addEventListener('click', relayout);

            zoomInButton.addEventListener('click', function () {
                zoom = Math.min(2.5, zoom * 1.2);
                applyZoom();
            });

            zoomOutButton.addEventListener('click', function () {
                zoom = Math.max(0.4, zoom / 1.2);
                applyZoom();
            });

            render();
            startSimulation();
        })();
    </script>
@endsection
