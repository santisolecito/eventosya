<div class="mb-3">
    <label class="form-label">Título del evento <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $event->title ?? '') }}" required>
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Categoría <span class="text-danger">*</span></label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Selecciona una categoría</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $event->category_id ?? '') == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Ciudad <span class="text-danger">*</span></label>
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
            value="{{ old('city', $event->city ?? '') }}" required>
        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Lugar / Recinto <span class="text-danger">*</span></label>
    <input type="text" name="venue" class="form-control @error('venue') is-invalid @enderror"
        value="{{ old('venue', $event->venue ?? '') }}" required>
    @error('venue') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Fecha <span class="text-danger">*</span></label>
        <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
            value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d') : '') }}" required>
        @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Hora <span class="text-danger">*</span></label>
        <input type="time" name="event_time" class="form-control @error('event_time') is-invalid @enderror"
            value="{{ old('event_time', $event->event_time ?? '') }}" required>
        @error('event_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Descripción <span class="text-danger">*</span></label>
    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $event->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Imagen de portada</label>
    <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
    @if(isset($event) && $event->cover_image)
        <div class="mt-2">
            <img src="{{ Storage::url($event->cover_image) }}" class="img-thumbnail" style="height:100px;">
        </div>
    @endif
    @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-check">
    <input type="checkbox" name="active" class="form-check-input" id="active" value="1"
        @checked(old('active', $event->active ?? true))>
    <label class="form-check-label" for="active">Evento activo (visible al público)</label>
</div>
