@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-cog"></i> Settings</h1>
    </div>

    <div class="row">
        <!-- Color Theme Card -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-paint-brush me-2"></i> Color Theme</h5>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('dashboard.settings.update.colors') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Primary Color (Start)</label>
                            <div class="input-group">
                                <input type="color" 
                                    class="form-control form-control-color"
                                    id="colorStart"
                                    name="color_start" 
                                    value="{{ $settings->color_start ?? '#446496' }}"
                                    style="min-width: 60px;">
                                <input type="text" 
                                    class="form-control"
                                    id="textColorStart"
                                    value="{{ $settings->color_start ?? '#446496' }}"
                                    oninput="updateColor('Start')">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Primary Color (End)</label>
                            <div class="input-group">
                                <input type="color"
                                    class="form-control form-control-color"
                                    id="colorEnd"
                                    name="color_end"
                                    value="{{ $settings->color_end ?? '#88A5DB' }}"
                                    style="min-width: 60px;">
                                <input type="text"
                                    class="form-control"
                                    id="textColorEnd"
                                    value="{{ $settings->color_end ?? '#88A5DB' }}"
                                    oninput="updateColor('End')">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Background Color</label>
                            <div class="input-group">
                                <input type="color"
                                    class="form-control form-control-color"
                                    id="colorBackground"
                                    name="color_background"
                                    value="{{ $settings->color_background ?? '#EBF1F6' }}"
                                    style="min-width: 60px;">
                                <input type="text"
                                    class="form-control"
                                    id="textColorBackground"
                                    value="{{ $settings->color_background ?? '#EBF1F6' }}"
                                    oninput="updateColor('Background')">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Preview</label>
                            <div class="preview-box rounded" id="colorPreview" style="
                                background: linear-gradient(135deg, {{ $settings->color_start ?? '#446496' }}, {{ $settings->color_end ?? '#88A5DB' }});
                                height: 80px;
                                border: 1px solid #dee2e6;
                                box-shadow: inset 0 0 10px rgba(0,0,0,0.1);">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Colors
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Logo Settings Card -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-image me-2"></i> Logo & School Name Settings</h5>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('dashboard.settings.update.logo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <label class="form-label fw-bold d-block">Current Logo</label>
                            <div class="logo-preview bg-light rounded p-4 mb-3 d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                <img src="{{ asset('storage/' . ($settings->logo ?? 'images/logo2.png')) }}"
                                    alt="Current Logo"
                                    class="img-fluid"
                                    style="max-height: 180px; object-fit: contain;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload New Logo</label>
                            <div class="input-group">
                                <input type="file"
                                    class="form-control"
                                    name="logo"
                                    accept="image/*"
                                    id="logoInput">
                                <label class="input-group-text" for="logoInput">
                                    <i class="fas fa-upload"></i>
                                </label>
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Recommended size: 200x200px, Max: 2MB
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">School Name</label>
                            <input type="text" 
                                class="form-control" 
                                name="school_name" 
                                value="{{ $settings->school_name ?? 'SMKN 4 Bogor' }}"
                                placeholder="Enter school name">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Logo & Name
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Settings page styles */
.form-control-color {
    padding: 0;
    height: 38px;
    cursor: pointer;
}

.form-control-color::-webkit-color-swatch {
    border: none;
    border-radius: 4px;
    padding: 0;
}

.form-control-color::-webkit-color-swatch-wrapper {
    padding: 0;
    border-radius: 4px;
}

.preview-box {
    transition: all 0.3s ease;
}

.preview-box:hover {
    transform: scale(1.02);
}

.logo-preview {
    background: repeating-linear-gradient(
        45deg,
        #f8f9fa,
        #f8f9fa 10px,
        #ffffff 10px,
        #ffffff 20px
    );
    transition: all 0.3s ease;
}

.logo-preview:hover {
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
</style>

<script>
// Function to validate hex color
function isValidHex(color) {
    return /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(color);
}

// Function to update color when text input changes
function updateColor(type) {
    const colorInput = document.getElementById(`color${type}`);
    const textInput = document.getElementById(`textColor${type}`);
    let value = textInput.value;

    // Add # if it's missing
    if (value.charAt(0) !== '#') {
        value = '#' + value;
        textInput.value = value;
    }

    // Validate and update if valid
    if (isValidHex(value)) {
        colorInput.value = value;
        textInput.style.borderColor = '';
        
        // Update preview if it's start or end color
        if (type === 'Start' || type === 'End') {
            updatePreview();
        }
    } else {
        textInput.style.borderColor = 'red';
    }
}

// Function to update preview
function updatePreview() {
    const startColor = document.getElementById('colorStart').value;
    const endColor = document.getElementById('colorEnd').value;
    document.getElementById('colorPreview').style.background = 
        `linear-gradient(135deg, ${startColor}, ${endColor})`;
}

// Update text input when color picker changes
document.querySelectorAll('input[type="color"]').forEach(input => {
    input.addEventListener('input', (e) => {
        const type = e.target.id.replace('color', '');
        document.getElementById(`textColor${type}`).value = e.target.value;
        
        if (type === 'Start' || type === 'End') {
            updatePreview();
        }
    });
});

// Add event listeners for text inputs
document.getElementById('textColorStart').addEventListener('input', () => updateColor('Start'));
document.getElementById('textColorEnd').addEventListener('input', () => updateColor('End'));
document.getElementById('textColorBackground').addEventListener('input', () => updateColor('Background'));

// Logo preview
document.getElementById('logoInput').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.logo-preview img');
            preview.src = e.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endsection 