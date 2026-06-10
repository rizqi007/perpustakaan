<div class="w-full overflow-x-auto p-4 bg-gray-100 rounded-lg border border-gray-200">
    <div class="text-sm font-bold text-gray-500 mb-2">Live Preview (Geser teks untuk mengatur posisi)</div>
    <div 
        x-data="{
            nameX: $wire.entangle('data.ticket_name_x'),
            nameY: $wire.entangle('data.ticket_name_y'),
            dateX: $wire.entangle('data.ticket_date_x'),
            dateY: $wire.entangle('data.ticket_date_y'),
            dragging: null,
            startX: 0,
            startY: 0,
            initialLeft: 0,
            initialTop: 0,
            scale: 1,
            
            init() {
                // Initialize scale on load if image is already cached
                this.$nextTick(() => {
                    const img = this.$refs.ticketImage;
                    if (img && img.complete) {
                        this.updateScale();
                    }
                });
            },

            updateScale() {
                 const img = this.$refs.ticketImage;
                 if (img && img.naturalWidth > 0) {
                     this.scale = img.clientWidth / img.naturalWidth;
                 }
            },

            startDrag(type, event) {
                this.dragging = type;
                this.startX = event.clientX;
                this.startY = event.clientY;
                
                if (type === 'name') {
                    this.initialLeft = parseInt(this.nameX) || 60;
                    this.initialTop = parseInt(this.nameY) || 110;
                } else {
                    this.initialLeft = parseInt(this.dateX) || 60;
                    this.initialTop = parseInt(this.dateY) || 160;
                }
                
                window.addEventListener('mousemove', this.onMouseMove);
                window.addEventListener('mouseup', this.onMouseUp);
            },
            
            onMouseMove(event) {
                if (!this.dragging) return;
                
                let dx = event.clientX - this.startX;
                let dy = event.clientY - this.startY;
                
                // Adjust dx/dy based on current scale
                // If displayed at 0.5x, moving 10px on screen means 20px on original image
                if (this.scale > 0) {
                    dx = dx / this.scale;
                    dy = dy / this.scale;
                }
                
                if (this.dragging === 'name') {
                    this.nameX = Math.round(this.initialLeft + dx);
                    this.nameY = Math.round(this.initialTop + dy);
                } else {
                    this.dateX = Math.round(this.initialLeft + dx);
                    this.dateY = Math.round(this.initialTop + dy);
                }
            },
            
            onMouseUp() {
                this.dragging = null;
                window.removeEventListener('mousemove', this.onMouseMove);
                window.removeEventListener('mouseup', this.onMouseUp);
            }
        }"
        x-init="
            // Bind context for event listeners
            onMouseMove = onMouseMove.bind($data);
            onMouseUp = onMouseUp.bind($data);
            window.addEventListener('resize', () => updateScale());
        "
        style="position: relative; width: 100%; overflow: hidden; user-select: none;">
        
        @php
            // In Livewire context (Filament Form), $this->data holds the form state
            $data = $this->data ?? [];
            
            // Attempt to resolve background image
            $bgImage = $data['ticket_bg_image'] ?? null;
            $bgUrl = asset('images/ticket-bg.jpg'); // Default

            if ($bgImage) {
                if (is_string($bgImage)) {
                    // Stored path
                    $bgUrl = \Illuminate\Support\Facades\Storage::url($bgImage);
                } elseif (is_array($bgImage)) {
                    $firstImage = array_values($bgImage)[0];
                    if (is_object($firstImage) && method_exists($firstImage, 'temporaryUrl')) {
                         $bgUrl = $firstImage->temporaryUrl();
                    } elseif (is_string($firstImage)) {
                         $bgUrl = \Illuminate\Support\Facades\Storage::url($firstImage);
                    }
                }
            }
        @endphp

        <div style="position: relative; display: inline-block; width: 100%;">
            <img 
                x-ref="ticketImage"
                @load="updateScale()"
                src="{{ $bgUrl }}" 
                style="width: 100%; height: auto; display: block; pointer-events: none;"
            >
            
            {{-- Name --}}
            <div 
                @mousedown="startDrag('name', $event)"
                style="position: absolute; cursor: move; border: 1px dashed rgba(0,0,0,0.2);"
                :style="{ 
                    left: ((nameX || 60) * scale) + 'px', 
                    top: ((nameY || 110) * scale) + 'px',
                    fontSize: (({{ $data['ticket_name_size'] ?? 32 }}) * scale) + 'px',
                    color: '{{ $data['ticket_name_color'] ?? '#000000' }}' 
                }"
                class="hover:outline hover:outline-2 hover:outline-blue-500 hover:bg-blue-500/10 rounded px-1"
            >
                <span style="font-family: Arial, sans-serif; font-weight: bold; line-height: 1;">Nama Tamu</span>
            </div>

            {{-- Date --}}
            <div 
                @mousedown="startDrag('date', $event)"
                style="position: absolute; cursor: move; border: 1px dashed rgba(0,0,0,0.2);"
                :style="{ 
                    left: ((dateX || 60) * scale) + 'px', 
                    top: ((dateY || 160) * scale) + 'px',
                    fontSize: (({{ $data['ticket_date_size'] ?? 20 }}) * scale) + 'px',
                    color: '{{ $data['ticket_date_color'] ?? '#333333' }}' 
                }"
                class="hover:outline hover:outline-2 hover:outline-blue-500 hover:bg-blue-500/10 rounded px-1"
            >
                <span style="font-family: Arial, sans-serif; line-height: 1;">10 Feb 2026 | 09:00 - 11:00</span>
            </div>
        </div>
    </div>
</div>
