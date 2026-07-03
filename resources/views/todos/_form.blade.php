<div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $todo?->title) }}" required maxlength="200" />
    @error('title') <small style="color:var(--danger);">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea id="notes" name="notes" rows="4">{{ old('notes', $todo?->notes) }}</textarea>
    @error('notes') <small style="color:var(--danger);">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="due_date">Due Date</label>
    <input type="datetime-local" id="due_date" name="due_date"
           value="{{ old('due_date', optional($todo?->due_date)->format('Y-m-d\TH:i')) }}" />
    @error('due_date') <small style="color:var(--danger);">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="priority">Priority</label>
    <select id="priority" name="priority">
        @foreach (['low','medium','high'] as $p)
            <option value="{{ $p }}" @selected(old('priority', $todo?->priority) === $p)>{{ ucfirst($p) }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status">
        @foreach (['pending','in_progress','done'] as $s)
            <option value="{{ $s }}" @selected(old('status', $todo?->status) === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
        @endforeach
    </select>
</div>
