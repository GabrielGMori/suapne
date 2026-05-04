<x-layouts.main title="components" bg="surface">
    <div class="showcase-page">

        <header class="showcase-header">
            <p class="showcase-eyebrow">Component Library</p>
            <h1 class="showcase-title">Input Types</h1>
            <p class="showcase-subtitle">All variants of <code>&lt;x-default-input /&gt;</code></p>
        </header>

        <main class="showcase-grid">

            {{-- ─── Text Inputs ──────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Text</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="text"
                        name="text_example"
                        label="Text"
                        placeholder="Type something..."
                    />

                    <x-default-input
                        type="email"
                        name="email_example"
                        label="Email"
                        placeholder="you@example.com"
                    />

                    <x-default-input
                        type="url"
                        name="url_example"
                        label="URL"
                        placeholder="https://example.com"
                    />

                    <x-default-input
                        type="tel"
                        name="tel_example"
                        label="Tel"
                        placeholder="+55 (41) 00000-0000"
                    />

                    <x-default-input
                        type="search"
                        name="search_example"
                        label="Search"
                        placeholder="Search..."
                    />

                    <x-default-input
                        type="number"
                        name="number_example"
                        label="Number"
                        placeholder="0"
                    />
                </div>
            </section>

            {{-- ─── Password ─────────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Password</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="password"
                        name="password_example"
                        label="Password"
                    />

                    <x-default-input
                        type="password_forgot"
                        name="password_forgot_example"
                        label="Password (with forgot link)"
                    />
                </div>
            </section>

            {{-- ─── Date & Time ──────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Date &amp; Time</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="date"
                        name="date_example"
                        label="Date"
                    />

                    <x-default-input
                        type="datetime"
                        name="datetime_example"
                        label="Date &amp; Time"
                    />

                    <x-default-input
                        type="time"
                        name="time_example"
                        label="Time"
                    />

                    <x-default-input
                        type="month"
                        name="month_example"
                        label="Month"
                    />

                    <x-default-input
                        type="week"
                        name="week_example"
                        label="Week"
                    />
                </div>
            </section>

            {{-- ─── Pickers ──────────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Pickers</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="color"
                        name="color_example"
                        label="Color"
                        value="#3b82f6"
                    />

                    <x-default-input
                        type="range"
                        name="range_example"
                        label="Range"
                        value="50"
                    />
                </div>
            </section>

            {{-- ─── Select & Multiselect ────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Select</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="select"
                        name="select_example"
                        label="Select (keyboard search)"
                        :options="[
                            'br' => 'Brazil',
                            'np' => 'Nepal',
                            'ca' => 'Canada',
                            'de' => 'Germany',
                            'jp' => 'Japan',
                            'au' => 'Australia',
                            'calories' => 'Calories',
                        ]"
                    />

                    <x-default-input
                        type="multiselect"
                        name="multiselect_example"
                        label="Multiselect (keyboard search)"
                        :options="[
                            'php'        => 'PHP',
                            'js'         => 'JavaScript',
                            'ts'         => 'TypeScript',
                            'python'     => 'Python',
                            'rust'       => 'Rust',
                            'go'         => 'Go',
                            'swift'      => 'Swift',
                            'kotlin'     => 'Kotlin',
                        ]"
                    />
                </div>
            </section>

            {{-- ─── File ────────────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">File</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="file"
                        name="file_example"
                        label="File"
                    />
                </div>
            </section>

            {{-- ─── Choices ──────────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Choices</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="checkbox"
                        name="checkbox_example"
                        label="Checkbox"
                    />

                    <x-default-input
                        type="radio"
                        name="radio_example"
                        label="Radio"
                    />
                </div>
            </section>

            {{-- ─── Actions ──────────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Actions</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="button"
                        name="button_example"
                        label="Button"
                        value="Click me"
                    />

                    <x-default-input
                        type="submit"
                        name="submit_example"
                        label="Submit"
                        value="Submit form"
                    />

                    <x-default-input
                        type="reset"
                        name="reset_example"
                        label="Reset"
                        value="Reset form"
                    />

                    <x-default-input
                        type="image"
                        name="image_example"
                        label="Image (submit)"
                        src="https://placehold.co/80x32"
                        alt="Submit"
                    />
                </div>
            </section>

            {{-- ─── Hidden (shown for completeness) ───────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Hidden</h2>

                <div class="showcase-row showcase-row--hidden">
                    <div class="showcase-hidden-note">
                        <code>&lt;x-default-input type="hidden" name="csrf_token" value="abc123" /&gt;</code>
                        <span class="showcase-hidden-badge">Not rendered — carries value silently in the DOM</span>
                    </div>
                    <x-default-input type="hidden" name="hidden_example" value="secret-value" />
                </div>
            </section>

            {{-- ─── Appearances ─────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Appearances</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="text"
                        appearance="default"
                        name="appearance_default"
                        label="Default"
                        placeholder="Default appearance"
                    />

                    <x-default-input
                        type="text"
                        appearance="outlined"
                        name="appearance_outlined"
                        label="Outlined"
                        placeholder="Outlined appearance"
                    />

                    <x-default-input
                        type="text"
                        appearance="surface"
                        name="appearance_surface"
                        label="Surface"
                        placeholder="Surface appearance"
                    />
                </div>
            </section>

            {{-- ─── Sizes ───────────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Sizes</h2>

                <div class="showcase-row showcase-row--align-end">
                    <x-default-input
                        type="text"
                        size="small"
                        name="size_small"
                        label="Small"
                        placeholder="Small"
                    />

                    <x-default-input
                        type="text"
                        size="medium"
                        name="size_medium"
                        label="Medium"
                        placeholder="Medium"
                    />

                    <x-default-input
                        type="text"
                        size="full"
                        name="size_full"
                        label="Full width"
                        placeholder="Full width"
                    />
                </div>
            </section>

            {{-- ─── Helper text ─────────────────────────────────────────────── --}}
            <section class="showcase-section">
                <h2 class="showcase-section-title">Helper Text</h2>

                <div class="showcase-row">
                    <x-default-input
                        type="text"
                        name="helper_example"
                        label="With helper"
                        placeholder="Enter your username"
                        helper="Only letters, numbers and underscores."
                    />
                </div>
            </section>

        </main>

    </div>

    <style>
        .showcase-page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 3rem 2rem 6rem;
            font-family: inherit;
        }

        /* ── Header ── */
        .showcase-header {
            margin-bottom: 3.5rem;
            border-bottom: 1px solid rgba(0,0,0,.08);
            padding-bottom: 2rem;
        }
        .showcase-eyebrow {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #6b7280;
            margin: 0 0 .5rem;
        }
        .showcase-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin: 0 0 .4rem;
            color: #111;
        }
        .showcase-subtitle {
            margin: 0;
            color: #6b7280;
            font-size: .95rem;
        }
        .showcase-subtitle code {
            background: #f3f4f6;
            border-radius: 4px;
            padding: .1em .4em;
            font-size: .88rem;
            color: #374151;
        }

        /* ── Sections ── */
        .showcase-grid {
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }
        .showcase-section {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .showcase-section-title {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #9ca3af;
            margin: 0;
            padding-bottom: .5rem;
            border-bottom: 1px dashed #e5e7eb;
        }

        /* ── Row ── */
        .showcase-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-start;
        }
        .showcase-row--align-end {
            align-items: flex-end;
        }
        .showcase-row--hidden {
            align-items: center;
        }

        /* ── Hidden note ── */
        .showcase-hidden-note {
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }
        .showcase-hidden-note code {
            font-size: .82rem;
            background: #f3f4f6;
            border-radius: 6px;
            padding: .5rem .75rem;
            color: #374151;
            border: 1px solid #e5e7eb;
        }
        .showcase-hidden-badge {
            font-size: .75rem;
            color: #9ca3af;
        }
    </style>
</x-layouts.main>