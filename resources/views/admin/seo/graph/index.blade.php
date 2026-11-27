@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-10">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-3xl font-extrabold text-gray-800">
                <i class="fas fa-search text-blue-600 ml-3"></i>
                دفترچه سئو
            </h2>
        </div>

        @include('admin.seo.partials.tabs')

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow-md p-5 border-r-4 border-blue-500">
                <p class="text-xs text-gray-500 mb-1">کلمات کلیدی</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['keywords']) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 border-r-4 border-amber-500">
                <p class="text-xs text-gray-500 mb-1">کارها</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['tasks']) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 border-r-4 border-emerald-500">
                <p class="text-xs text-gray-500 mb-1">ارتباط‌ها</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['links']) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 border-r-4 border-gray-400">
                <p class="text-xs text-gray-500 mb-1">کارهای بدون کلمه کلیدی</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['orphans']) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-4 md:p-6">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">گراف ارتباط کلمات کلیدی و کارها</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        گره‌های آبی کلمات کلیدی و گره‌های رنگی کارها هستند. برای جابه‌جایی، گره‌ها را بکشید.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600 bg-gray-50 rounded-xl px-4 py-2">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-blue-600 ring-2 ring-white shadow"></span>
                        کلمه کلیدی
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-slate-400 ring-2 ring-white shadow"></span>
                        انجام نشده
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-amber-500 ring-2 ring-white shadow"></span>
                        در حال انجام
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-green-600 ring-2 ring-white shadow"></span>
                        انجام شده
                    </span>
                </div>
            </div>

            <div id="seo-graph-wrap"
                 class="relative w-full rounded-xl border border-gray-100 bg-gradient-to-br from-slate-50 via-white to-blue-50/40 overflow-hidden"
                 style="height: 640px;">
                <svg id="seo-graph" class="w-full h-full block" xmlns="http://www.w3.org/2000/svg"></svg>
                <div id="seo-graph-empty" class="hidden absolute inset-0 flex flex-col items-center justify-center text-gray-500">
                    <i class="fas fa-project-diagram text-4xl text-gray-300 mb-3"></i>
                    <p class="font-semibold">هنوز داده‌ای برای نمایش در گراف وجود ندارد.</p>
                    <p class="text-sm mt-1">ابتدا کلمه کلیدی و کار اضافه کنید.</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        (function () {
            const svg = document.getElementById('seo-graph');
            const emptyState = document.getElementById('seo-graph-empty');
            const rawNodes = @json($nodes, JSON_UNESCAPED_UNICODE);
            const rawLinks = @json($edges, JSON_UNESCAPED_UNICODE);

            if (!rawNodes.length) {
                emptyState.classList.remove('hidden');
                return;
            }

            const NS = 'http://www.w3.org/2000/svg';
            const width = 1000;
            const height = 640;
            const statusColors = {
                todo: '#94a3b8',
                in_progress: '#f59e0b',
                done: '#16a34a',
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

            const linkLayer = document.createElementNS(NS, 'g');
            const nodeLayer = document.createElementNS(NS, 'g');
            svg.append(linkLayer, nodeLayer);

            const linkElements = links.map(function (link) {
                const line = document.createElementNS(NS, 'line');
                line.setAttribute('stroke', '#cbd5e1');
                line.setAttribute('stroke-width', '1.2');
                linkLayer.appendChild(line);

                return line;
            });

            const hideTaskLabels = nodes.length > 45;

            const nodeElements = nodes.map(function (node) {
                const group = document.createElementNS(NS, 'g');
                group.setAttribute('class', 'seo-graph-node');
                group.setAttribute('data-node-id', node.id);
                group.style.cursor = 'grab';

                const isKeyword = node.type === 'keyword';
                const radius = isKeyword ? 17 : 10;
                const color = isKeyword ? '#2563eb' : (statusColors[node.status] || statusColors.todo);

                const circle = document.createElementNS(NS, 'circle');
                circle.setAttribute('r', String(radius));
                circle.setAttribute('fill', color);
                circle.setAttribute('stroke', '#ffffff');
                circle.setAttribute('stroke-width', '2');
                circle.style.filter = 'drop-shadow(0 1px 2px rgba(15, 23, 42, 0.28))';
                group.appendChild(circle);

                const title = document.createElementNS(NS, 'title');
                title.textContent = node.tooltip || node.label;
                circle.appendChild(title);

                const label = document.createElementNS(NS, 'text');
                label.textContent = node.label.length > 26 ? node.label.slice(0, 25) + '…' : node.label;
                label.setAttribute('text-anchor', 'middle');
                label.setAttribute('y', String(radius + 14));
                label.setAttribute('font-size', isKeyword ? '12' : '10');
                label.setAttribute('font-family', 'Vazirmatn, sans-serif');
                label.setAttribute('fill', isKeyword ? '#1e3a8a' : '#475569');
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
                });

                group.addEventListener('mouseleave', function () {
                    if (!isKeyword && hideTaskLabels) {
                        label.style.opacity = '0';
                    }
                });

                return { group: group, node: node, label: label };
            });

            let alpha = 1;
            let running = false;
            let draggedNode = null;
            let dragOffsetX = 0;
            let dragOffsetY = 0;

            function restart() {
                if (running) {
                    return;
                }

                running = true;

                if (alpha <= 0.02) {
                    alpha = 0.5;
                }

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
                        const strength = (a.type === 'keyword' || b.type === 'keyword') ? 2600 : 1100;
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
                    const restLength = 105;
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

                    const pad = 45;
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

            function toSvgPoint(event) {
                const point = svg.createSVGPoint();
                point.x = event.clientX;
                point.y = event.clientY;

                return point.matrixTransform(svg.getScreenCTM().inverse());
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

                const point = toSvgPoint(event);
                draggedNode = node;
                dragOffsetX = node.x - point.x;
                dragOffsetY = node.y - point.y;
                node.vx = 0;
                node.vy = 0;
                group.style.cursor = 'grabbing';
                svg.setPointerCapture(event.pointerId);
                alpha = Math.max(alpha, 0.3);
                restart();
                event.preventDefault();
            });

            svg.addEventListener('pointermove', function (event) {
                if (!draggedNode) {
                    return;
                }

                const point = toSvgPoint(event);
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

                nodeElements.forEach(function (element) {
                    if (element.node === draggedNode) {
                        element.group.style.cursor = 'grab';
                    }
                });

                draggedNode = null;

                if (svg.hasPointerCapture(event.pointerId)) {
                    svg.releasePointerCapture(event.pointerId);
                }

                alpha = Math.max(alpha, 0.2);
                restart();
            }

            svg.addEventListener('pointerup', endDrag);
            svg.addEventListener('pointercancel', endDrag);

            render();
            restart();
        })();
    </script>
@endsection
