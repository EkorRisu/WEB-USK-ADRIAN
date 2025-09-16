@extends('layouts.admin')

@section('content')
    <div class="form-container">
        <!-- Header Section -->
        <div class="form-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">
                        <span class="title-icon">➕</span>
                        Add New Product
                    </h1>
                    <p class="page-subtitle">Create a new product to expand your inventory</p>
                </div>
                <div class="breadcrumb-nav">
                    <span class="breadcrumb-item">Products</span>
                    <span class="breadcrumb-separator">→</span>
                    <span class="breadcrumb-item active">Add New</span>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-wrapper">
            <div class="form-card">
                <div class="form-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 0%"></div>
                    </div>
                    <div class="progress-text">Complete the form below</div>
                </div>

                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf

                    <!-- Product Name Field -->
                    <div class="form-group">
                        <label for="nama" class="form-label">
                            <span class="label-icon">📦</span>
                            Product Name
                        </label>
                        <div class="input-wrapper">
                            <input type="text" name="nama" id="nama"
                                class="form-input @error('nama') error @enderror"
                                value="{{ old('nama') }}"
                                placeholder="Enter product name (e.g., Premium Coffee Beans)"
                                required>
                            <div class="input-icon">📝</div>
                        </div>
                        @error('nama')
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">Choose a clear, descriptive name for your product</div>
                    </div>

                    <!-- Category Field -->
                    <div class="form-group">
                        <label for="kategori_id" class="form-label">
                            <span class="label-icon">🏷️</span>
                            Category
                        </label>
                        <div class="select-wrapper">
                            <select name="kategori_id" id="kategori_id"
                                class="form-select @error('kategori_id') error @enderror"
                                required>
                                <option value="">Select a category</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="select-icon">🔽</div>
                        </div>
                        @error('kategori_id')
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">Select the most appropriate category for this product</div>
                    </div>

                    <!-- Price Field -->
                    <div class="form-group">
                        <label for="harga" class="form-label">
                            <span class="label-icon">💰</span>
                            Price
                        </label>
                        <div class="input-wrapper price-wrapper">
                            <div class="price-currency">Rp</div>
                            <input type="number" name="harga" id="harga"
                                class="form-input price-input @error('harga') error @enderror"
                                value="{{ old('harga') }}"
                                placeholder="0"
                                min="0"
                                step="1000"
                                required>
                            <div class="input-icon">💸</div>
                        </div>
                        @error('harga')
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">Set the selling price for this product</div>
                    </div>

                    <!-- Stock Field -->
                    <div class="form-group">
                        <label for="stok" class="form-label">
                            <span class="label-icon">📦</span>
                            Stock
                        </label>
                        <div class="input-wrapper">
                            <input type="number" name="stok" id="stok"
                                class="form-input @error('stok') error @enderror"
                                value="{{ old('stok', 0) }}"
                                placeholder="Enter stock quantity"
                                min="0"
                                required>
                            <div class="input-icon">🔢</div>
                        </div>
                        @error('stok')
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">Enter the available quantity of this product</div>
                    </div>

                    <!-- Image Upload Field -->
                    <div class="form-group">
                        <label for="foto" class="form-label">
                            <span class="label-icon">📷</span>
                            Product Image
                        </label>

                        <div class="file-upload-wrapper">
                            <div class="file-drop-zone" id="dropZone">
                                <div class="file-upload-content">
                                    <div class="upload-icon">📁</div>
                                    <h4>Drop your product image here</h4>
                                    <p>or <span class="upload-link">browse files</span></p>
                                    <div class="upload-requirements">
                                        JPG, PNG, GIF up to 5MB
                                    </div>
                                </div>
                                <input type="file" name="foto" id="foto"
                                    class="file-input @error('foto') error @enderror"
                                    accept="image/*">
                            </div>

                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <img id="previewImg" src="" alt="Preview">
                                <div class="preview-overlay">
                                    <button type="button" class="remove-image" id="removeImage">
                                        <span>🗑️</span>
                                    </button>
                                </div>
                                <div class="image-info">
                                    <span id="fileName"></span>
                                    <span id="fileSize"></span>
                                </div>
                            </div>
                        </div>

                        @error('foto')
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="field-hint">Upload a high-quality image that represents your product</div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                            <span class="btn-icon">←</span>
                            Back to Products
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span class="btn-icon">💾</span>
                            <span class="btn-text">Save Product</span>
                            <div class="btn-loader" style="display: none;">
                                <div class="spinner"></div>
                            </div>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Card -->
            <div class="help-card">
                <h4>💡 Tips for Adding Products</h4>
                <ul>
                    <li><strong>Clear Names:</strong> Use descriptive, searchable product names</li>
                    <li><strong>Right Category:</strong> Choose the most relevant category</li>
                    <li><strong>Fair Pricing:</strong> Research market prices before setting</li>
                    <li><strong>Quality Images:</strong> Use well-lit, high-resolution photos</li>
                    <li><strong>Consistency:</strong> Maintain consistent naming conventions</li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('productForm');
                const nameInput = document.getElementById('nama');
                const categorySelect = document.getElementById('kategori_id');
                const priceInput = document.getElementById('harga');
                const fileInput = document.getElementById('foto');
                const dropZone = document.getElementById('dropZone');
                const imagePreview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                const fileName = document.getElementById('fileName');
                const fileSize = document.getElementById('fileSize');
                const removeImageBtn = document.getElementById('removeImage');
                const progressFill = document.querySelector('.progress-fill');
                const submitBtn = document.getElementById('submitBtn');

                // Progress tracking
                function updateProgress() {
                    let progress = 0;
                    if (nameInput.value.trim()) progress += 25;
                    if (categorySelect.value) progress += 25;
                    if (priceInput.value && parseFloat(priceInput.value) > 0) progress += 25;
                    if (fileInput.files.length > 0) progress += 25;

                    progressFill.style.width = progress + '%';

                    if (progress === 100) {
                        progressFill.style.background = 'linear-gradient(90deg, #10b981, #059669)';
                    } else {
                        progressFill.style.background = 'linear-gradient(90deg, #667eea, #764ba2)';
                    }
                }

                // Price formatting
                priceInput.addEventListener('input', function() {
                    updateProgress();
                });

                // Format price display
                priceInput.addEventListener('blur', function() {
                    if (this.value) {
                        const value = parseFloat(this.value);
                        if (!isNaN(value)) {
                            this.value = Math.round(value);
                        }
                    }
                });

                nameInput.addEventListener('input', updateProgress);
                categorySelect.addEventListener('change', updateProgress);

                // File upload handling
                dropZone.addEventListener('click', () => fileInput.click());

                dropZone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('drag-over');
                });

                dropZone.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('drag-over');
                });

                dropZone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('drag-over');
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        fileInput.files = files;
                        handleFileSelect(files[0]);
                    }
                });

                fileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        handleFileSelect(e.target.files[0]);
                    }
                });

                function handleFileSelect(file) {
                    if (!file.type.startsWith('image/')) {
                        alert('Please select an image file');
                        return;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        fileName.textContent = file.name;
                        fileSize.textContent = formatFileSize(file.size);

                        dropZone.style.display = 'none';
                        imagePreview.style.display = 'block';
                        updateProgress();
                    };
                    reader.readAsDataURL(file);
                }

                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }

                removeImageBtn.addEventListener('click', function() {
                    fileInput.value = '';
                    dropZone.style.display = 'block';
                    imagePreview.style.display = 'none';
                    updateProgress();
                });

                // Form submission
                form.addEventListener('submit', function(e) {
                    const btnText = submitBtn.querySelector('.btn-text');
                    const btnLoader = submitBtn.querySelector('.btn-loader');

                    btnText.style.display = 'none';
                    btnLoader.style.display = 'inline-block';
                    submitBtn.disabled = true;
                });

                // Input animations
                const inputs = document.querySelectorAll('.form-input, .form-select');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });

                    input.addEventListener('blur', function() {
                        if (!this.value) {
                            this.parentElement.classList.remove('focused');
                        }
                    });

                    // Check if input has value on load
                    if (input.value) {
                        input.parentElement.classList.add('focused');
                    }
                });
            });
        </script>
    @endpush

    <style>
            .form-container {
        background: linear-gradient(135deg, #18181b 0%, #27272a 100%);
        min-height: 100vh;
        padding: 2rem;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

        /* Header Section */
        .form-header {
            background: rgba(71, 71, 71, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            background:white;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .title-icon {
            font-size: 2rem;
        }

        .page-subtitle {
            color: #c7c7c8;
            font-size: 1.1rem;
            margin: 0.5rem 0 0 0;
        }

        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .breadcrumb-item {
            color: #64748b;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 20px;
        }

        .breadcrumb-item.active {
            background: #667eea;
            color: white;
        }

        .breadcrumb-separator {
            color: #94a3b8;
        }

        /* Form Wrapper */
        .form-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

                .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 200px);
            overflow-y: visible;
            padding-bottom: 100px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Styling untuk scrollbar pada Chrome/Safari */
        .form-card::-webkit-scrollbar {
            width: 8px;
        }

        .form-card::-webkit-scrollbar-track {
            background: #e5e7eb;
            border-radius: 4px;
        }

        .form-card::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 4px;
        }

        .form-card::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }

        .form-progress {
            margin-bottom: 2rem;
            text-align: center;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .progress-text {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .label-icon {
            font-size: 1.1rem;
        }

        /* Input Styles */
        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 3rem 1rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
        }

        .input-wrapper.focused .input-icon {
            color: #667eea;
        }

        /* Price Input Styles */
        .price-wrapper {
            display: flex;
            align-items: center;
        }

        .price-currency {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-weight: 600;
            z-index: 10;
        }

        .price-input {
            padding-left: 3rem !important;
        }

        /* Select Styles */
        .select-wrapper {
            position: relative;
        }

        .form-select {
            width: 100%;
            padding: 1rem 3rem 1rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            appearance: none;
        }

        .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-select.error {
            border-color: #ef4444;
        }

        .select-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.875rem;
            pointer-events: none;
        }

        .select-wrapper.focused .select-icon {
            color: #667eea;
        }

        /* File Upload Styles */
        .file-upload-wrapper {
            position: relative;
        }

        .file-drop-zone {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .file-drop-zone:hover,
        .file-drop-zone.drag-over {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .file-upload-content h4 {
            margin: 0.5rem 0;
            color: #374151;
            font-weight: 600;
        }

        .file-upload-content p {
            margin: 0.5rem 0;
            color: #6b7280;
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .upload-link {
            color: #667eea;
            font-weight: 600;
            cursor: pointer;
        }

        .upload-requirements {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.5rem;
        }

        .file-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        /* Image Preview */
        .image-preview {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }

        .image-preview img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .preview-overlay {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }

        .remove-image {
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            color: white;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .remove-image:hover {
            background: #ef4444;
        }

        .image-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.75rem;
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
        }

        /* Error Messages */
        .error-message {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .error-icon {
            font-size: 1rem;
        }

        /* Field Hints */
        .field-hint {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            min-width: 150px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-icon {
            font-size: 1rem;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Help Card */
        .help-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .help-card h4 {
            color: #374151;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .help-card ul {
            margin: 0;
            padding-left: 1rem;
        }

        .help-card li {
            color: #6b7280;
            margin-bottom: 0.75rem;
            line-height: 1.5;
        }

        .help-card strong {
            color: #374151;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 1rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .page-title {
                font-size: 2rem;
            }

            .form-wrapper {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-card,
        .help-card {
            animation: slideInUp 0.5s ease-out;
        }

        .form-group {
            animation: slideInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
    </style>
@endsection