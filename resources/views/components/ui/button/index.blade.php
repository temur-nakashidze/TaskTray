@php use Illuminate\View\ComponentAttributeBag; @endphp
{{--
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  x-ui.button — COMPONENT DOCUMENTATION
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  BASIC USAGE
  ───────────
  <x-ui.button>Click me</x-ui.button>
  <x-ui.button label="Click me" />
  <x-ui.button icon="pencil-square" label="Edit" />

  NOTE: slot and label are interchangeable. Slot takes priority if both provided.
  Buttons with no slot and no label automatically become squared (icon-only).


  SIZES          size="xs|sm|md|lg"        default: md
  ──────────────────────────────────────────────────────
  <x-ui.button size="xs" label="Tiny" />
  <x-ui.button size="sm" label="Small" />
  <x-ui.button size="md" label="Medium" />
  <x-ui.button size="lg" label="Large" />


  VARIANTS       variant="outline|soft|ghost|subtle|solid|primary|danger|none"
  ──────────────────────────────────────────────────────────────────────────────
  <x-ui.button variant="outline" label="Outline" />        ← default
  <x-ui.button variant="soft"    label="Soft" />
  <x-ui.button variant="ghost"   label="Ghost" />
  <x-ui.button variant="subtle"  label="Subtle" />
  <x-ui.button variant="solid"   label="Solid" />
  <x-ui.button variant="primary" label="Primary" />        ← gradient glow effect
  <x-ui.button variant="danger"  label="Danger" />         ← always red
  <x-ui.button variant="none"    label="Unstyled" />


  COLORS         color="..."      works with: outline, soft, ghost, subtle, solid, primary
  ──────────────────────────────────────────────────────────────────────────────────────────
  Available: primary, accent, white, slate, neutral, zinc, stone,
             red, red-amber, orange, amber, yellow, lime, green,
             emerald, teal, cyan, sky, blue, indigo, violet,
             purple, fuchsia, pink, rose, neutral

  <x-ui.button variant="soft"  color="red"    label="Delete" />
  <x-ui.button variant="solid" color="green"  label="Confirm" />
  <x-ui.button variant="ghost" color="accent" label="Accent" />


  ICONS
  ──────────────────────────────────────────────────────────────────────────────
  icon="..."         leading icon
  iconAfter="..."    trailing icon
  iconVariant="..."  passed to x-ui.icon
  iconSize="..."     overrides auto size (xs|sm|md|lg)
  iconClasses="..."  extra classes on the icon element

  <x-ui.button icon="pencil-square" label="Edit" />
  <x-ui.button iconAfter="arrow-right" label="Next" />
  <x-ui.button icon="ps:trash" squared />                  ← icon-only, auto-squared


  SQUARED        no slot + no label = auto-squared. Force with: squared
  ──────────────────────────────────────────────────────────────────────
  <x-ui.button icon="pencil-square" />                     ← auto-squared
  <x-ui.button icon="pencil-square" squared />             ← force-squared


  BADGE
  ──────────────────────────────────────────────────────────────────────────────
  badge="..."        renders a badge inside the button (right side)
  badge:color="..."  passes color to the badge component
  badge:size="..."   overrides badge size (auto-set based on button size)

  <x-ui.button label="Notifications" badge="4" />
  <x-ui.button label="Alerts" badge="12" badge:color="red" />


  STATES
  ──────────────────────────────────────────────────────────────────────────────
  disabled           grays out, removes pointer events
  loading            shows spinner, hides content
  active             marks button as active state

  <x-ui.button disabled label="Disabled" />
  <x-ui.button loading  label="Saving..." />
  <x-ui.button :loading="$isSaving" label="Save" />


  LOADING INDICATOR
  ──────────────────────────────────────────────────────────────────────────────
  loadingIndicator   default: true. Set false to suppress the spinner entirely.
  Auto-triggers on wire:click, wire:loading, and type="submit".

  <x-ui.button wire:click="save" label="Save" />           ← spinner auto-shown
  <x-ui.button :loadingIndicator="false" label="Save" />   ← no spinner


  AS / TYPE      render as different element
  ──────────────────────────────────────────────────────────────────────────────
  as="button|a"       default: button
  type="button|submit|reset"

  <x-ui.button as="a" href="/dashboard" label="Go" />
  <x-ui.button type="submit" label="Submit" />


  TOOLTIP        pure CSS, no JS, no wrapper component
  ──────────────────────────────────────────────────────────────────────────────
  tooltip="..."              text shown on hover
  tooltipPlacement="..."     top (default) | bottom | left | right
  responsiveTooltip          if set: tooltip only shows when label is hidden
                             (requires responsive prop to be set too)

  <x-ui.button icon="ps:trash" tooltip="Delete item" squared />
  <x-ui.button icon="ps:trash" tooltip="Delete item" tooltipPlacement="left" squared />

  Always visible tooltip with label:
  <x-ui.button icon="ps:save" label="Save" tooltip="Save draft" />

  Tooltip only when collapsed (label hidden below breakpoint):
  <x-ui.button icon="ps:save" label="Save Draft" tooltip="Save Draft" responsive responsiveTooltip />


  RESPONSIVE     hides label below a breakpoint, collapses to icon-only size
  ──────────────────────────────────────────────────────────────────────────────
  responsive             hides label below md (768px) — default breakpoint
  responsive="sm"        hides below sm  (640px)
  responsive="md"        hides below md  (768px)
  responsive="lg"        hides below lg  (1024px)
  responsive="xl"        hides below xl  (1280px)

  <x-ui.button icon="ps:chart-line" label="Statistics" responsive />
  <x-ui.button icon="ps:chart-line" label="Statistics" responsive="lg" />

  Combined with tooltip (show tooltip only when collapsed):
  <x-ui.button
      icon="ps:chart-line"
      label="Statistics"
      tooltip="View statistics"
      responsive="lg"
      responsiveTooltip
  />


  COMMON PATTERNS
  ──────────────────────────────────────────────────────────────────────────────
  Icon-only with tooltip (toolbar actions):
  <x-ui.button icon="pencil-square" variant="soft" color="neutral"
      tooltip="Edit" tooltipPlacement="left" squared />

  Responsive toolbar button:
  <x-ui.button icon="ps:chart-line" label="Statistics" variant="soft"
      color="neutral" tooltip="Statistics" responsive responsiveTooltip />

  Submit button with loading:
  <x-ui.button type="submit" variant="primary" color="accent"
      icon="ps:check" label="Save Changes" />

  Danger action:
  <x-ui.button variant="soft" color="red" icon="ps:trash"
      tooltip="Delete" tooltipPlacement="left" squared />

  Link button:
  <x-ui.button as="a" href="/settings" variant="ghost"
      icon="cog-6-tooth" label="Settings" />


  NOTES
  ──────────────────────────────────────────────────────────────────────────────
  • All standard HTML attributes (wire:click, x-on:click, class, id, etc.)
    pass through to the underlying element via $attributes.
  • Tooltip requires app.css to include the .btn-tooltip CSS block.
  • responsive + responsiveTooltip requires an icon to be set — otherwise
    the button would become completely empty when collapsed.
  • variant="danger" ignores the color prop (always red).
  • overflow-hidden on variant="primary" can clip dropdowns inside — avoid
    nesting interactive children inside primary buttons.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
--}}
@aware(['icon', 'iconClasses', 'iconVariant', 'iconAfter', 'iconSize', 'badge'])

@props([
    'type' => 'button',
    'size' => 'md',
    'color' => false,
    'disabled' => false,
    'loading' => false,
    'loadingIndicator' => true,
    'variant' => 'outline',
    'icon' => null,
    'iconAfter' => null,
    'iconVariant' => null,
    'iconSize' => null,
    'iconColor' => null,
    'as' => 'button',
    'iconClasses' => null,
    'squared' => false,
    'active' => false,
    'badge' => null,
    'label' => null,
    'tooltip' => null,
    'tooltipPlacement' => 'top',
    'responsive' => null,
    'responsiveTooltip' => false,
    'tooltipDelay' => 400,
    'font' => 'label',
])

@php
    // ─── Responsive label hiding ───────────────────────────────────────────
    $responsiveBreakpoint = match (true) {
        $responsive === '' || $responsive === true => 'md',
        is_string($responsive) && filled($responsive) => $responsive,
        default => null,
    };

    $labelHideClass = $responsiveBreakpoint ? $responsiveBreakpoint . ':inline' : null;

    $responsiveSquaredClass = $responsiveBreakpoint
        ? match ($size) {
            'lg' => 'w-12 ' .
                $responsiveBreakpoint .
                ':w-auto ' .
                $responsiveBreakpoint .
                ':' .
                ($icon ? 'ps-4' : 'ps-5') .
                ' ' .
                $responsiveBreakpoint .
                ':' .
                ($iconAfter || $badge ? 'pe-4' : 'pe-5'),
            'sm' => 'w-7.5 ' .
                $responsiveBreakpoint .
                ':w-auto ' .
                $responsiveBreakpoint .
                ':' .
                ($icon ? 'ps-2' : 'ps-3') .
                ' ' .
                $responsiveBreakpoint .
                ':' .
                ($iconAfter || $badge ? 'pe-2' : 'pe-3'),
            'xs' => 'w-6 ' .
                $responsiveBreakpoint .
                ':w-auto ' .
                $responsiveBreakpoint .
                ':' .
                ($icon ? 'ps-1' : 'ps-2') .
                ' ' .
                $responsiveBreakpoint .
                ':' .
                ($iconAfter || $badge ? 'pe-1' : 'pe-2'),
            default => 'w-10 ' .
                $responsiveBreakpoint .
                ':w-auto ' .
                $responsiveBreakpoint .
                ':' .
                ($icon ? 'ps-3' : 'ps-4') .
                ' ' .
                $responsiveBreakpoint .
                ':' .
                ($iconAfter || $badge ? 'pe-3' : 'pe-4'),
        }
        : null;

    // ─── Tooltip logic ────────────────────────────────────────────────────
    $hasTooltip = filled($tooltip);
    // tooltipResponsive: show tooltip only below the responsive breakpoint (when label is hidden)
    // tooltipAlways: show tooltip at all sizes
    $tooltipResponsive = $hasTooltip && $responsiveTooltip && $responsiveBreakpoint;
    $tooltipAlways = $hasTooltip && !$tooltipResponsive;

    // CSS class that hides the ::after pseudo-element above the breakpoint
    // e.g. "md:btn-tooltip-hidden" — handled in CSS
    $tooltipHideAboveClass = $tooltipResponsive ? 'btn-tooltip-hide-above-' . $responsiveBreakpoint : null;

    $squared = $squared || ($slot->isEmpty() && blank($label) && $label !== false);

    $isDiv = $as === 'div';

    $fontClass =
        $size === 'xs'
            ? 'font-label'
            : match ($font) {
                'display' => 'font-display',
                'mono' => 'font-mono',
                'sans' => 'font-sans',
                default => 'font-label',
            };

    $sizeClasses = match ($size) {
        'lg' => ($isDiv ? '' : '[:where(&)]:h-11 ') .
            'text-md rounded-button font-medium ' .
            ($squared
                ? 'w-12'
                : $responsiveSquaredClass ??
                    ($icon ? 'ps-4' : 'ps-5') . ' ' . ($iconAfter || $badge ? 'pe-4' : 'pe-5')),

        'sm' => ($isDiv ? '' : '[:where(&)]:h-7 ') .
            'text-sm rounded-[calc(var(--radius-button)*0.75)] font-medium ' .
            ($squared
                ? 'w-7'
                : $responsiveSquaredClass ??
                    ($icon ? 'ps-2' : 'ps-3') . ' ' . ($iconAfter || $badge ? 'pe-2' : 'pe-3')),

        'xs' => ($isDiv ? '' : '[:where(&)]:h-6 ') .
            'text-xs rounded-[calc(var(--radius-button)*0.5)]  font-medium ' .
            ($squared
                ? 'w-6'
                : $responsiveSquaredClass ??
                    ($icon ? 'ps-1' : 'ps-2') . ' ' . ($iconAfter || $badge ? 'pe-1' : 'pe-2')),

        default => ($isDiv ? '' : '[:where(&)]:h-9 ') .
            'text-sm rounded-button font-medium ' .
            ($squared
                ? 'w-9'
                : $responsiveSquaredClass ??
                    ($icon ? 'ps-3' : 'ps-4') . ' ' . ($iconAfter || $badge ? 'pe-3' : 'pe-4')),
    };

    // Applied once, outside the match

    $iconSize =
        $iconSize ??
        match ($size) {
            'xs' => 'xs',
            'sm' => 'sm',
            'lg' => 'lg',
            default => 'md',
        };

    $iconClasses =
        $iconClasses ??
        match ($variant) {
            'primary' => 'text-[var(--color-primary-fg)]',
            'solid' => 'text-[var(--color-solid-content)]',
            'soft' => 'text-[var(--color-soft-content)]/90 hover:text-[var(--color-soft-content)]',
            'subtle' => 'text-[var(--color-subtle-text)] group-hover:text-[var(--color-subtle-text-hover)]',
            'ghost' => 'text-[var(--color-ghost-text)]/90 group-hover:text-[var(--color-ghost-text-hover)]',
            'outline'
                => 'text-[var(--color-outline-fg)]/90 group-hover:text-[var(--color-outline-fg)] dark:text-[var(--color-outline-content)]/90 dark:group-hover:text-[var(--color-outline-content)]',
            'danger' => 'text-white',
            default => '',
        };

    $badgeAttributes = new ComponentAttributeBag();
    foreach ($attributes->getAttributes() as $key => $value) {
        if (str_starts_with($key, 'badge:')) {
            $badgeAttributes[substr($key, 6)] = $value;
        }
    }

    // ─── all your existing color match blocks unchanged ────────────────────
    $primaryColors = match ($color) {
        // Neutrals — genuinely different in dark mode
        'slate'
            => '[--color-primary:var(--color-slate-800)] [--color-primary-content:var(--color-slate-700)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-slate-200)] dark:[--color-primary-fg:var(--color-slate-800)] dark:[--color-primary-shadow:var(--color-slate-950)]',
        'neutral'
            => '[--color-primary:var(--color-neutral-500)] [--color-primary-content:var(--color-neutral-700)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-neutral-200)] dark:[--color-primary-fg:var(--color-neutral-800)] dark:[--color-primary-shadow:var(--color-neutral-950)]',
        'zinc'
            => '[--color-primary:var(--color-zinc-800)] [--color-primary-content:var(--color-zinc-700)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-zinc-200)] dark:[--color-primary-fg:var(--color-zinc-800)] dark:[--color-primary-shadow:var(--color-zinc-950)]',
        'stone'
            => '[--color-primary:var(--color-stone-800)] [--color-primary-content:var(--color-stone-700)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-stone-200)] dark:[--color-primary-fg:var(--color-stone-800)] dark:[--color-primary-shadow:var(--color-stone-950)]',
        // Colors — same in both modes
        'accent'
            => '[--color-primary:var(--color-accent-600)] dark:[--color-primary:var(--color-accent-700)] [--color-primary-content:var(--color-accent-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-accent-800)]  dark:[--color-primary-shadow:var(--color-accent-950)] dark:[--color-primary-content:var(--color-accent-500)]',
        'red'
            => '[--color-primary:var(--color-red-600)] dark:[--color-primary:var(--color-red-700)] [--color-primary-content:var(--color-red-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-red-800)] dark:[--color-primary-shadow:var(--color-red-950)] dark:[--color-primary-content:var(--color-red-500)]',
        'orange'
            => '[--color-primary:var(--color-orange-600)] dark:[--color-primary:var(--color-orange-700)] [--color-primary-content:var(--color-orange-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-orange-800)] dark:[--color-primary-shadow:var(--color-orange-950)] dark:[--color-primary-content:var(--color-orange-500)]',
        'amber'
            => '[--color-primary:var(--color-amber-600)] dark:[--color-primary:var(--color-amber-700)] [--color-primary-content:var(--color-amber-700)] [--color-primary-fg:var(--color-amber-950)] [--color-primary-shadow:var(--color-amber-800)] dark:[--color-primary-shadow:var(--color-amber-950)] dark:[--color-primary-content:var(--color-amber-500)]',
        'yellow'
            => '[--color-primary:var(--color-yellow-600)] dark:[--color-primary:var(--color-yellow-700)] [--color-primary-content:var(--color-yellow-700)] [--color-primary-fg:var(--color-yellow-950)] [--color-primary-shadow:var(--color-yellow-800)] dark:[--color-primary-shadow:var(--color-yellow-950)] dark:[--color-primary-content:var(--color-yellow-500)]',
        'lime'
            => '[--color-primary:var(--color-lime-600)] dark:[--color-primary:var(--color-lime-700)] [--color-primary-content:var(--color-lime-700)] [--color-primary-fg:var(--color-lime-900)] [--color-primary-shadow:var(--color-lime-800)] dark:[--color-primary-shadow:var(--color-lime-950)] dark:[--color-primary-content:var(--color-lime-500)]',
        'green'
            => '[--color-primary:var(--color-green-600)] dark:[--color-primary:var(--color-green-700)] [--color-primary-content:var(--color-green-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-green-800)] dark:[--color-primary-shadow:var(--color-green-950)] dark:[--color-primary-content:var(--color-green-500)]',
        'emerald'
            => '[--color-primary:var(--color-emerald-600)] dark:[--color-primary:var(--color-emerald-700)] [--color-primary-content:var(--color-emerald-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-emerald-800)] dark:[--color-primary-shadow:var(--color-emerald-950)] dark:[--color-primary-content:var(--color-emerald-500)]',
        'teal'
            => '[--color-primary:var(--color-teal-600)] dark:[--color-primary:var(--color-teal-700)] [--color-primary-content:var(--color-teal-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-teal-800)] dark:[--color-primary-shadow:var(--color-teal-950)] dark:[--color-primary-content:var(--color-teal-500)]',
        'cyan'
            => '[--color-primary:var(--color-cyan-600)] dark:[--color-primary:var(--color-cyan-700)] [--color-primary-content:var(--color-cyan-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-cyan-800)] dark:[--color-primary-shadow:var(--color-cyan-950)] dark:[--color-primary-content:var(--color-cyan-500)]',
        'sky'
            => '[--color-primary:var(--color-sky-600)] dark:[--color-primary:var(--color-sky-700)] [--color-primary-content:var(--color-sky-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-sky-800)] dark:[--color-primary-shadow:var(--color-sky-950)] dark:[--color-primary-content:var(--color-sky-500)]',
        'blue'
            => '[--color-primary:var(--color-blue-600)] dark:[--color-primary:var(--color-blue-700)] [--color-primary-content:var(--color-blue-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-blue-800)] dark:[--color-primary-shadow:var(--color-blue-950)] dark:[--color-primary-content:var(--color-blue-500)]',
        'indigo'
            => '[--color-primary:var(--color-indigo-600)] dark:[--color-primary:var(--color-indigo-700)] [--color-primary-content:var(--color-indigo-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-indigo-800)]  dark:[--color-primary-shadow:var(--color-indigo-950)] dark:[--color-primary-content:var(--color-indigo-500)]',
        'violet'
            => '[--color-primary:var(--color-violet-600)] dark:[--color-primary:var(--color-violet-700)] [--color-primary-content:var(--color-violet-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-violet-800)] dark:[--color-primary-shadow:var(--color-violet-950)] dark:[--color-primary-content:var(--color-violet-500)]',
        'purple'
            => '[--color-primary:var(--color-purple-600)] dark:[--color-primary:var(--color-purple-700)] [--color-primary-content:var(--color-purple-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-purple-800)] dark:[--color-primary-shadow:var(--color-purple-950)] dark:[--color-primary-content:var(--color-emerald-500)]',
        'fuchsia'
            => '[--color-primary:var(--color-fuchsia-600)] dark:[--color-primary:var(--color-fuchsia-700)] [--color-primary-content:var(--color-fuchsia-700)] [--color-primary-fg:var(--color-purple-50)] [--color-primary-shadow:var(--color-fuchsia-800)] dark:[--color-primary-shadow:var(--color-fuchsia-950)] dark:[--color-primary-content:var(--color-fuchsia-500)]',
        'pink'
            => '[--color-primary:var(--color-pink-600)] dark:[--color-primary:var(--color-pink-700)] [--color-primary-content:var(--color-pink-700)] [--color-primary-fg:var(--color-white)] [--color-primary-shadow:var(--color-pink-800)] dark:[--color-primary-shadow:var(--color-pink-950)] dark:[--color-primary-content:var(--color-pink-500)]',
        'rose'
            => '[--color-primary:var(--color-rose-600)] dark:[--color-primary:var(--color-rose-700)] [--color-primary-content:var(--color-rose-700)] [--color-primary-fg:var(--color-neutral-50)] [--color-primary-shadow:var(--color-rose-800)] dark:[--color-primary-shadow:var(--color-rose-950)] dark:[--color-primary-content:var(--color-rose-500)]',

        default
            => '[--color-primary:var(--color-theme-600)] dark:[--color-primary:var(--color-theme-700)] [--color-primary-content:var(--color-theme-700)] [--color-primary-shadow:var(--color-theme-800)] dark:[--color-primary-shadow:var(--color-theme-950)] [--color-primary-fg:var(--color-white)] dark:[--color-primary-content:var(--color-theme-500)]',
    };

    $softColors = match ($color) {
        'primary'
            => '[--color-soft:var(--color-theme-500)] [--color-soft-content:var(--color-theme-600)] [--color-soft-fg:var(--color-theme-700)] dark:[--color-soft:var(--color-theme-300)] dark:[--color-soft-content:var(--color-theme-300)] dark:[--color-soft-fg:var(--color-theme-300)]',
        'accent'
            => '[--color-soft:var(--color-accent-500)] [--color-soft-content:var(--color-accent-600)] [--color-soft-fg:var(--color-accent-700)] dark:[--color-soft:var(--color-accent-300)] dark:[--color-soft-content:var(--color-accent-300)] dark:[--color-soft-fg:var(--color-accent-300)]',
        'slate'
            => '[--color-soft:var(--color-slate-500)] [--color-soft-content:var(--color-slate-600)] [--color-soft-fg:var(--color-slate-700)] dark:[--color-soft:var(--color-slate-300)] dark:[--color-soft-content:var(--color-slate-300)] dark:[--color-soft-fg:var(--color-slate-300)]',
        'neutral'
            => '[--color-soft:var(--color-neutral-500)] [--color-soft-content:var(--color-neutral-600)] [--color-soft-fg:var(--color-neutral-700)] dark:[--color-soft:var(--color-neutral-300)] dark:[--color-soft-content:var(--color-neutral-300)] dark:[--color-soft-fg:var(--color-neutral-300)]',
        'zinc'
            => '[--color-soft:var(--color-zinc-500)] [--color-soft-content:var(--color-zinc-600)] [--color-soft-fg:var(--color-zinc-700)] dark:[--color-soft:var(--color-zinc-300)] dark:[--color-soft-content:var(--color-zinc-300)] dark:[--color-soft-fg:var(--color-zinc-300)]',
        'stone'
            => '[--color-soft:var(--color-stone-500)] [--color-soft-content:var(--color-stone-600)] [--color-soft-fg:var(--color-stone-700)] dark:[--color-soft:var(--color-stone-300)] dark:[--color-soft-content:var(--color-stone-300)] dark:[--color-soft-fg:var(--color-stone-300)]',
        'red'
            => '[--color-soft:var(--color-red-500)] [--color-soft-content:var(--color-red-600)] [--color-soft-fg:var(--color-red-700)] dark:[--color-soft:var(--color-red-400)] dark:[--color-soft-content:var(--color-red-400)] dark:[--color-soft-fg:var(--color-red-400)]',
        'orange'
            => '[--color-soft:var(--color-orange-500)] [--color-soft-content:var(--color-orange-600)] [--color-soft-fg:var(--color-orange-700)] dark:[--color-soft:var(--color-orange-300)] dark:[--color-soft-content:var(--color-orange-300)] dark:[--color-soft-fg:var(--color-orange-300)]',
        'amber'
            => '[--color-soft:var(--color-amber-500)] [--color-soft-content:var(--color-amber-600)] [--color-soft-fg:var(--color-amber-700)] dark:[--color-soft:var(--color-amber-300)] dark:[--color-soft-content:var(--color-amber-300)] dark:[--color-soft-fg:var(--color-amber-300)]',
        'yellow'
            => '[--color-soft:var(--color-yellow-500)] [--color-soft-content:var(--color-yellow-600)] [--color-soft-fg:var(--color-yellow-700)] dark:[--color-soft:var(--color-yellow-300)] dark:[--color-soft-content:var(--color-yellow-300)] dark:[--color-soft-fg:var(--color-yellow-300)]',
        'lime'
            => '[--color-soft:var(--color-lime-500)] [--color-soft-content:var(--color-lime-600)] [--color-soft-fg:var(--color-lime-700)] dark:[--color-soft:var(--color-lime-300)] dark:[--color-soft-content:var(--color-lime-300)] dark:[--color-soft-fg:var(--color-lime-300)]',
        'green'
            => '[--color-soft:var(--color-green-500)] [--color-soft-content:var(--color-green-600)] [--color-soft-fg:var(--color-green-700)] dark:[--color-soft:var(--color-green-300)] dark:[--color-soft-content:var(--color-green-300)] dark:[--color-soft-fg:var(--color-green-300)]',
        'emerald'
            => '[--color-soft:var(--color-emerald-500)] [--color-soft-content:var(--color-emerald-600)] [--color-soft-fg:var(--color-emerald-700)] dark:[--color-soft:var(--color-emerald-300)] dark:[--color-soft-content:var(--color-emerald-300)] dark:[--color-soft-fg:var(--color-emerald-300)]',
        'teal'
            => '[--color-soft:var(--color-teal-500)] [--color-soft-content:var(--color-teal-600)] [--color-soft-fg:var(--color-teal-700)] dark:[--color-soft:var(--color-teal-300)] dark:[--color-soft-content:var(--color-teal-300)] dark:[--color-soft-fg:var(--color-teal-300)]',
        'cyan'
            => '[--color-soft:var(--color-cyan-500)] [--color-soft-content:var(--color-cyan-600)] [--color-soft-fg:var(--color-cyan-700)] dark:[--color-soft:var(--color-cyan-300)] dark:[--color-soft-content:var(--color-cyan-300)] dark:[--color-soft-fg:var(--color-cyan-300)]',
        'sky'
            => '[--color-soft:var(--color-sky-500)] [--color-soft-content:var(--color-sky-600)] [--color-soft-fg:var(--color-sky-700)] dark:[--color-soft:var(--color-sky-300)] dark:[--color-soft-content:var(--color-sky-300)] dark:[--color-soft-fg:var(--color-sky-300)]',
        'blue'
            => '[--color-soft:var(--color-blue-500)] [--color-soft-content:var(--color-blue-600)] [--color-soft-fg:var(--color-blue-700)] dark:[--color-soft:var(--color-blue-300)] dark:[--color-soft-content:var(--color-blue-300)] dark:[--color-soft-fg:var(--color-blue-300)]',
        'indigo'
            => '[--color-soft:var(--color-indigo-500)] [--color-soft-content:var(--color-indigo-600)] [--color-soft-fg:var(--color-indigo-700)] dark:[--color-soft:var(--color-indigo-300)] dark:[--color-soft-content:var(--color-indigo-300)] dark:[--color-soft-fg:var(--color-indigo-300)]',
        'violet'
            => '[--color-soft:var(--color-violet-500)] [--color-soft-content:var(--color-violet-600)] [--color-soft-fg:var(--color-violet-700)] dark:[--color-soft:var(--color-violet-300)] dark:[--color-soft-content:var(--color-violet-300)] dark:[--color-soft-fg:var(--color-violet-300)]',
        'purple'
            => '[--color-soft:var(--color-purple-500)] [--color-soft-content:var(--color-purple-600)] [--color-soft-fg:var(--color-purple-700)] dark:[--color-soft:var(--color-purple-300)] dark:[--color-soft-content:var(--color-purple-300)] dark:[--color-soft-fg:var(--color-purple-300)]',
        'fuchsia'
            => '[--color-soft:var(--color-fuchsia-500)] [--color-soft-content:var(--color-fuchsia-600)] [--color-soft-fg:var(--color-fuchsia-700)] dark:[--color-soft:var(--color-fuchsia-300)] dark:[--color-soft-content:var(--color-fuchsia-300)] dark:[--color-soft-fg:var(--color-fuchsia-300)]',
        'pink'
            => '[--color-soft:var(--color-pink-500)] [--color-soft-content:var(--color-pink-600)] [--color-soft-fg:var(--color-pink-700)] dark:[--color-soft:var(--color-pink-300)] dark:[--color-soft-content:var(--color-pink-300)] dark:[--color-soft-fg:var(--color-pink-300)]',
        'rose'
            => '[--color-soft:var(--color-rose-500)] [--color-soft-content:var(--color-rose-600)] [--color-soft-fg:var(--color-rose-700)] dark:[--color-soft:var(--color-rose-300)] dark:[--color-soft-content:var(--color-rose-300)] dark:[--color-soft-fg:var(--color-rose-300)]',
        default
            => '[--color-soft:var(--color-neutral-500)] [--color-soft-content:var(--color-neutral-600)] [--color-soft-fg:var(--color-neutral-700)] dark:[--color-soft:var(--color-neutral-300)] dark:[--color-soft-content:var(--color-neutral-300)] dark:[--color-soft-fg:var(--color-neutral-100)]',
    };

    $subtleColors = match ($color) {
        'accent'
            => '[--color-subtle-text:var(--color-accent-accent-700)] dark:[--color-subtle-text:var(--color-accent-300)]',
        'slate'
            => '[--color-subtle-text:var(--color-slate-600)] [--color-subtle-text-hover:var(--color-slate-800)] dark:[--color-subtle-text:var(--color-slate-400)] dark:[--color-subtle-text-hover:var(--color-white)]',
        'neutral'
            => '[--color-subtle-text:var(--color-neutral-600)] [--color-subtle-text-hover:var(--color-neutral-800)] dark:[--color-subtle-text:var(--color-neutral-400)] dark:[--color-subtle-text-hover:var(--color-white)]',
        'zinc'
            => '[--color-subtle-text:var(--color-zinc-600)] [--color-subtle-text-hover:var(--color-zinc-800)] dark:[--color-subtle-text:var(--color-zinc-400)] dark:[--color-subtle-text-hover:var(--color-white)]',
        'stone'
            => '[--color-subtle-text:var(--color-stone-600)] [--color-subtle-text-hover:var(--color-stone-800)] dark:[--color-subtle-text:var(--color-stone-400)] dark:[--color-subtle-text-hover:var(--color-white)]',
        'red'
            => '[--color-subtle-text:var(--color-red-500)] [--color-subtle-text-hover:var(--color-red-700)] dark:[--color-subtle-text:var(--color-red-400)] dark:[--color-subtle-text-hover:var(--color-red-300)]',
        'red-amber'
            => '[--color-subtle-text:var(--color-red-amber-500)] [--color-subtle-text-hover:var(--color-red-amber-700)] dark:[--color-subtle-text:var(--color-red-amber-400)] dark:[--color-subtle-text-hover:var(--color-red-amber-300)]',
        'orange'
            => '[--color-subtle-text:var(--color-orange-500)] [--color-subtle-text-hover:var(--color-orange-700)] dark:[--color-subtle-text:var(--color-orange-400)] dark:[--color-subtle-text-hover:var(--color-orange-300)]',
        'amber'
            => '[--color-subtle-text:var(--color-amber-600)] [--color-subtle-text-hover:var(--color-amber-800)] dark:[--color-subtle-text:var(--color-amber-400)] dark:[--color-subtle-text-hover:var(--color-amber-300)]',
        'yellow'
            => '[--color-subtle-text:var(--color-yellow-600)] [--color-subtle-text-hover:var(--color-yellow-800)] dark:[--color-subtle-text:var(--color-yellow-400)] dark:[--color-subtle-text-hover:var(--color-yellow-300)]',
        'lime'
            => '[--color-subtle-text:var(--color-lime-600)] [--color-subtle-text-hover:var(--color-lime-800)] dark:[--color-subtle-text:var(--color-lime-400)] dark:[--color-subtle-text-hover:var(--color-lime-300)]',
        'green'
            => '[--color-subtle-text:var(--color-green-600)] [--color-subtle-text-hover:var(--color-green-800)] dark:[--color-subtle-text:var(--color-green-400)] dark:[--color-subtle-text-hover:var(--color-green-300)]',
        'emerald'
            => '[--color-subtle-text:var(--color-emerald-600)] [--color-subtle-text-hover:var(--color-emerald-800)] dark:[--color-subtle-text:var(--color-emerald-400)] dark:[--color-subtle-text-hover:var(--color-emerald-300)]',
        'teal'
            => '[--color-subtle-text:var(--color-teal-600)] [--color-subtle-text-hover:var(--color-teal-800)] dark:[--color-subtle-text:var(--color-teal-400)] dark:[--color-subtle-text-hover:var(--color-teal-300)]',
        'cyan'
            => '[--color-subtle-text:var(--color-cyan-600)] [--color-subtle-text-hover:var(--color-cyan-800)] dark:[--color-subtle-text:var(--color-cyan-400)] dark:[--color-subtle-text-hover:var(--color-cyan-300)]',
        'sky'
            => '[--color-subtle-text:var(--color-sky-600)] [--color-subtle-text-hover:var(--color-sky-800)] dark:[--color-subtle-text:var(--color-sky-400)] dark:[--color-subtle-text-hover:var(--color-sky-300)]',
        'blue'
            => '[--color-subtle-text:var(--color-blue-500)] [--color-subtle-text-hover:var(--color-blue-700)] dark:[--color-subtle-text:var(--color-blue-400)] dark:[--color-subtle-text-hover:var(--color-blue-300)]',
        'indigo'
            => '[--color-subtle-text:var(--color-indigo-500)] [--color-subtle-text-hover:var(--color-indigo-700)] dark:[--color-subtle-text:var(--color-indigo-400)] dark:[--color-subtle-text-hover:var(--color-indigo-300)]',
        'violet'
            => '[--color-subtle-text:var(--color-violet-500)] [--color-subtle-text-hover:var(--color-violet-700)] dark:[--color-subtle-text:var(--color-violet-400)] dark:[--color-subtle-text-hover:var(--color-violet-300)]',
        'purple'
            => '[--color-subtle-text:var(--color-purple-500)] [--color-subtle-text-hover:var(--color-purple-700)] dark:[--color-subtle-text:var(--color-purple-400)] dark:[--color-subtle-text-hover:var(--color-purple-300)]',
        'fuchsia'
            => '[--color-subtle-text:var(--color-fuchsia-600)] [--color-subtle-text-hover:var(--color-fuchsia-800)] dark:[--color-subtle-text:var(--color-fuchsia-400)] dark:[--color-subtle-text-hover:var(--color-fuchsia-300)]',
        'pink'
            => '[--color-subtle-text:var(--color-pink-600)] [--color-subtle-text-hover:var(--color-pink-800)] dark:[--color-subtle-text:var(--color-pink-400)] dark:[--color-subtle-text-hover:var(--color-pink-300)]',
        'rose'
            => '[--color-subtle-text:var(--color-rose-500)] [--color-subtle-text-hover:var(--color-rose-700)] dark:[--color-subtle-text:var(--color-rose-400)] dark:[--color-subtle-text-hover:var(--color-rose-300)]',
        'white'
            => '[--color-subtle-text:var(--color-neutral-50)] [--color-subtle-text-hover:var(--color-white)] dark:[--color-subtle-text:var(--color-neutral-50)] dark:[--color-subtle-text-hover:var(--color-white)]',
        default
            => '[--color-subtle-text:var(--color-neutral-600)] [--color-subtle-text-hover:var(--color-neutral-700)] dark:[--color-subtle-text:var(--color-neutral-200)] dark:[--color-subtle-text-hover:var(--color-neutral-50)]',
    };

    $outlineColors = match ($color) {
        'primary'
            => '[--color-outline:var(--color-theme-500)] [--color-outline-content:var(--color-theme-600)] [--color-outline-shadow:var(--color-theme-900)] [--color-outline-fg:var(--color-theme-700)] dark:[--color-outline:var(--color-theme-300)] dark:[--color-outline-content:var(--color-theme-300)] dark:[--color-outline-fg:var(--color-theme-300)]',
        'accent'
            => '[--color-outline:var(--color-accent-500)] [--color-outline-content:var(--color-accent-600)] [--color-outline-shadow:var(--color-accent-950)] [--color-outline-fg:var(--color-accent-700)] dark:[--color-outline:var(--color-accent-300)] dark:[--color-outline-content:var(--color-accent-300)] dark:[--color-outline-fg:var(--color-accent-200)]',
        'slate'
            => '[--color-outline:var(--color-slate-500)] [--color-outline-content:var(--color-slate-600)] [--color-outline-shadow:var(--color-slate-950)] [--color-outline-fg:var(--color-slate-700)] dark:[--color-outline:var(--color-slate-300)] dark:[--color-outline-content:var(--color-slate-300)] dark:[--color-outline-fg:var(--color-slate-200)]',
        'neutral'
            => '[--color-outline:var(--color-neutral-500)] [--color-outline-content:var(--color-neutral-600)] [--color-outline-shadow:var(--color-neutral-950)] [--color-outline-fg:var(--color-neutral-700)] dark:[--color-outline:var(--color-neutral-300)] dark:[--color-outline-content:var(--color-neutral-300)] dark:[--color-outline-fg:var(--color-neutral-200)]',
        'zinc'
            => '[--color-outline:var(--color-zinc-500)] [--color-outline-content:var(--color-zinc-600)] [--color-outline-shadow:var(--color-zinc-950)] [--color-outline-fg:var(--color-zinc-700)] dark:[--color-outline:var(--color-zinc-300)] dark:[--color-outline-content:var(--color-zinc-300)] dark:[--color-outline-fg:var(--color-zinc-200)]',
        'stone'
            => '[--color-outline:var(--color-stone-500)] [--color-outline-content:var(--color-stone-600)] [--color-outline-shadow:var(--color-stone-950)] [--color-outline-fg:var(--color-stone-700)] dark:[--color-outline:var(--color-stone-300)] dark:[--color-outline-content:var(--color-stone-300)] dark:[--color-outline-fg:var(--color-stone-200)]',
        'red'
            => '[--color-outline:var(--color-red-500)] [--color-outline-content:var(--color-red-600)] [--color-outline-shadow:var(--color-red-950)] [--color-outline-fg:var(--color-red-700)] dark:[--color-outline:var(--color-red-300)] dark:[--color-outline-content:var(--color-red-400)] dark:[--color-outline-fg:var(--color-red-200)]',
        'orange'
            => '[--color-outline:var(--color-orange-500)] [--color-outline-content:var(--color-orange-600)] [--color-outline-shadow:var(--color-orange-950)] [--color-outline-fg:var(--color-orange-700)] dark:[--color-outline:var(--color-orange-300)] dark:[--color-outline-content:var(--color-orange-400)] dark:[--color-outline-fg:var(--color-orange-200)]',
        'amber'
            => '[--color-outline:var(--color-amber-500)] [--color-outline-content:var(--color-amber-600)] [--color-outline-shadow:var(--color-amber-950)] [--color-outline-fg:var(--color-amber-700)] dark:[--color-outline:var(--color-amber-300)] dark:[--color-outline-content:var(--color-amber-400)] dark:[--color-outline-fg:var(--color-amber-200)]',
        'yellow'
            => '[--color-outline:var(--color-yellow-500)] [--color-outline-content:var(--color-yellow-600)] [--color-outline-shadow:var(--color-yellow-950)] [--color-outline-fg:var(--color-yellow-700)] dark:[--color-outline:var(--color-yellow-300)] dark:[--color-outline-content:var(--color-yellow-400)] dark:[--color-outline-fg:var(--color-yellow-200)]',
        'lime'
            => '[--color-outline:var(--color-lime-500)] [--color-outline-content:var(--color-lime-600)] [--color-outline-shadow:var(--color-lime-950)] [--color-outline-fg:var(--color-lime-700)] dark:[--color-outline:var(--color-lime-300)] dark:[--color-outline-content:var(--color-lime-400)] dark:[--color-outline-fg:var(--color-lime-200)]',
        'green'
            => '[--color-outline:var(--color-green-500)] [--color-outline-content:var(--color-green-600)] [--color-outline-shadow:var(--color-green-50)] [--color-outline-fg:var(--color-green-700)] dark:[--color-outline:var(--color-green-300)] dark:[--color-outline-content:var(--color-green-400)] dark:[--color-outline-fg:var(--color-green-200)]',
        'emerald'
            => '[--color-outline:var(--color-emerald-500)] [--color-outline-content:var(--color-emerald-600)] [--color-outline-shadow:var(--color-emerald-950)] [--color-outline-fg:var(--color-emerald-700)] dark:[--color-outline:var(--color-emerald-300)] dark:[--color-outline-content:var(--color-emerald-400)] dark:[--color-outline-fg:var(--color-emerald-200)]',
        'teal'
            => '[--color-outline:var(--color-teal-500)] [--color-outline-content:var(--color-teal-600)] [--color-outline-shadow:var(--color-teal-950)] [--color-outline-fg:var(--color-teal-700)] dark:[--color-outline:var(--color-teal-300)] dark:[--color-outline-content:var(--color-teal-400)] dark:[--color-outline-fg:var(--color-teal-200)]',
        'cyan'
            => '[--color-outline:var(--color-cyan-500)] [--color-outline-content:var(--color-cyan-600)] [--color-outline-shadow:var(--color-cyan-950)] [--color-outline-fg:var(--color-cyan-700)] dark:[--color-outline:var(--color-cyan-300)] dark:[--color-outline-content:var(--color-cyan-400)] dark:[--color-outline-fg:var(--color-cyan-200)]',
        'sky'
            => '[--color-outline:var(--color-sky-500)] [--color-outline-content:var(--color-sky-600)] [--color-outline-shadow:var(--color-sky-950)] [--color-outline-fg:var(--color-sky-700)] dark:[--color-outline:var(--color-sky-300)] dark:[--color-outline-content:var(--color-sky-400)] dark:[--color-outline-fg:var(--color-sky-200)]',
        'blue'
            => '[--color-outline:var(--color-blue-500)] [--color-outline-content:var(--color-blue-600)] [--color-outline-shadow:var(--color-blue-950)] [--color-outline-fg:var(--color-blue-700)] dark:[--color-outline:var(--color-blue-300)] dark:[--color-outline-content:var(--color-blue-400)] dark:[--color-outline-fg:var(--color-blue-200)]',
        'indigo'
            => '[--color-outline:var(--color-indigo-500)] [--color-outline-content:var(--color-indigo-600)] [--color-outline-shadow:var(--color-indigo-950)] [--color-outline-fg:var(--color-indigo-700)] dark:[--color-outline:var(--color-indigo-300)] dark:[--color-outline-content:var(--color-indigo-400)] dark:[--color-outline-fg:var(--color-indigo-200)]',
        'violet'
            => '[--color-outline:var(--color-violet-500)] [--color-outline-content:var(--color-violet-600)] [--color-outline-shadow:var(--color-violet-950)] [--color-outline-fg:var(--color-violet-700)] dark:[--color-outline:var(--color-violet-300)] dark:[--color-outline-content:var(--color-violet-400)] dark:[--color-outline-fg:var(--color-violet-200)]',
        'purple'
            => '[--color-outline:var(--color-purple-500)] [--color-outline-content:var(--color-purple-600)] [--color-outline-shadow:var(--color-purple-950)] [--color-outline-fg:var(--color-purple-700)] dark:[--color-outline:var(--color-purple-300)] dark:[--color-outline-content:var(--color-purple-400)] dark:[--color-outline-fg:var(--color-purple-200)]',
        'fuchsia'
            => '[--color-outline:var(--color-fuchsia-500)] [--color-outline-content:var(--color-fuchsia-600)] [--color-outline-shadow:var(--color-fuchsia-950)] [--color-outline-fg:var(--color-fuchsia-700)] dark:[--color-outline:var(--color-fuchsia-300)] dark:[--color-outline-content:var(--color-fuchsia-400)] dark:[--color-outline-fg:var(--color-fuchsia-200)]',
        'pink'
            => '[--color-outline:var(--color-pink-500)] [--color-outline-content:var(--color-pink-600)] [--color-outline-shadow:var(--color-pink-950)] [--color-outline-fg:var(--color-pink-700)] dark:[--color-outline:var(--color-pink-300)] dark:[--color-outline-content:var(--color-pink-400)] dark:[--color-outline-fg:var(--color-pink-200)]',
        'rose'
            => '[--color-outline:var(--color-rose-500)] [--color-outline-content:var(--color-rose-600)] [--color-outline-shadow:var(--color-rose-950)] [--color-outline-fg:var(--color-rose-700)] dark:[--color-outline:var(--color-rose-300)] dark:[--color-outline-content:var(--color-rose-400)] dark:[--color-outline-fg:var(--color-rose-200)]',
        default
            => '[--color-outline:var(--color-neutral-300)] [--color-outline-content:var(--color-neutral-600)] [--color-outline-shadow:var(--color-neutral-950)] [--color-outline-fg:var(--color-neutral-700)]/90 dark:[--color-outline:var(--color-neutral-300)] dark:[--color-outline-content:var(--color-neutral-600)] dark:[--color-outline-fg:var(--color-neutral-100)]/90',
    };

    $variantClasses = match ($variant) {
        'primary' => [
            'bg-[var(--color-primary)]/90',
            'text-[var(--color-primary-fg)]',
            'border border-[var(--color-primary-content)]/80 dark:border-[var(--color-primary-content)]',
            '[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-primary-shadow)_30%,transparent),inset_0_-1px_4px_color-mix(in_srgb,var(--color-primary-content)_50%,transparent)] hover:[box-shadow:inset_0_-2px_10px_color-mix(in_srgb,var(--color-primary-content)_80%,transparent)] dark:hover:[box-shadow:inset_0_-2px_10px_color-mix(in_srgb,var(--color-primary-content)_90%,transparent)]',
            'dark:[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-primary-content)_0%,transparent),inset_0_-1px_4px_color-mix(in_srgb,var(--color-primary-content)_90%,transparent)]',
            'hover:brightness-[0.94]',
            'active:brightness-[1.10] active:shadow-[inset_0_2px_6px_color-mix(in_srgb,var(--color-primary-shadow)_50%,transparent)] dark:active:shadow-[inset_0_2px_6px_color-mix(in_srgb,var(--color-primary-shadow)_50%,transparent)]',
            $primaryColors => filled($color),
        ],
        'soft' => [
            'active:bg-[var(--color-soft)]/30 dark:active:bg-[var(--color-soft)]/30',
            'bg-[var(--color-soft)]/10 hover:bg-[var(--color-soft)]/20 dark:bg-[var(--color-soft)]/12 dark:hover:bg-[var(--color-soft)]/20',
            'text-[var(--color-soft-fg)]/90 hover:text-[var(--color-soft-fg)] border border-transparent',
            $softColors => filled($color),
        ],
        'subtle' => [
            'bg-transparent',
            'text-[var(--color-subtle-text)] hover:text-[var(--color-subtle-text-hover)]',
            $subtleColors => filled($color),
        ],
        'ghost' => [
            'active:bg-[var(--color-soft)]/20',
            'bg-transparent hover:bg-[var(--color-soft)]/10',
            'text-[var(--color-soft-fg)]/90 hover:text-[var(--color-soft-fg)] border border-transparent',
            $softColors => filled($color),
        ],
        'outline' => [
            'active:shadow-[inset_0_2px_4px_color-mix(in_srgb,var(--color-outline-content)_20%,transparent)] active:bg-[color-mix(in_srgb,var(--color-outline)_22%,white)] dark:active:bg-[color-mix(in_srgb,var(--color-outline)_22%,var(--color-neutral-900))] dark:active:shadow-[inset_0_2px_5px_color-mix(in_srgb,var(--color-outline-shadow)_40%,transparent)]',
            'bg-[color-mix(in_srgb,var(--color-outline)_8%,white)] hover:bg-[color-mix(in_srgb,var(--color-outline)_15%,white)] dark:bg-[color-mix(in_srgb,var(--color-outline)_15%,var(--color-neutral-900))] dark:hover:bg-[color-mix(in_srgb,var(--color-outline)_20%,var(--color-neutral-900))]',
            'border border-[var(--color-outline-content)]/40 hover:border-[var(--color-outline-content)]/50 ',
            'text-[var(--color-outline-fg)]/90 hover:text-[var(--color-outline-fg)]',
            '[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-outline-content)_12%,transparent),inset_0_-1px_4px_color-mix(in_srgb,var(--color-outline-fg)_10%,transparent)] hover:[box-shadow:inset_0_-2px_8px_color-mix(in_srgb,var(--color-outline-fg)_15%,transparent)] dark:[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-outline-shadow)_50%,transparent),inset_0_-1px_6px_color-mix(in_srgb,var(--color-outline)_10%,transparent)]',
            $outlineColors => filled($color),
        ],
        'danger' => ['bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500', 'text-white'],
        default => [],
    };

    $classes = [
        'group relative [:where(&)]:inline-flex items-center justify-center gap-x-2 whitespace-nowrap transition-ui',
        'disabled:opacity-35 disabled:cursor-default disabled:pointer-events-none cursor-pointer select-none',
        '[&_a]:no-underline [&_a]:decoration-none [&_a:hover]:no-underline' => $variant !== 'none',
        '[:where(&)]:rounded-field' => $variant !== 'none',
        '[&>[data-loading=true]:first-child]:flex',
        '[&>[data-loading=true]:first-child~*]:opacity-0',
        'flex-shrink-0' => $squared,
        $sizeClasses,
        $fontClass,
        ...$variantClasses,
        // ─── tooltip classes ───────────────────────────────────────────────
        'btn-tooltip' => $hasTooltip,
        'btn-tooltip-top' => $hasTooltip && $tooltipPlacement === 'top',
        'btn-tooltip-bottom' => $hasTooltip && $tooltipPlacement === 'bottom',
        'btn-tooltip-left' => $hasTooltip && $tooltipPlacement === 'left',
        'btn-tooltip-right' => $hasTooltip && $tooltipPlacement === 'right',
        $tooltipHideAboveClass => $tooltipResponsive,
    ];

    $hasClickAction = filled($attributes->whereStartsWith('wire:click')->first());
    $hasWireLoading = filled($attributes->whereStartsWith('wire:loading')->first());

    $loadingAttributes = new ComponentAttributeBag();
    $loadingAttributes = $loadingAttributes->merge(
        $hasWireLoading || $hasClickAction || $type === 'submit'
            ? [
                'wire:loading.attr' => 'data-loading',
                'wire:target' => $attributes->has('wire:target')
                    ? $attributes->get('wire:target')
                    : $attributes->whereStartsWith('wire:click')->first() ?? null,
            ]
            : [],
    );

    $loadingAttributes = $loadingAttributes->merge($loading ? ['data-loading' => 'true'] : []);
@endphp

<x-ui.button.abstract :$as :$type :attributes="$attributes->class($classes)->merge([
    'role'          => $as === 'a' && !$attributes->has('href') ? 'button' : null,
    'aria-busy'     => $loading ? 'true' : 'false',
    'aria-disabled' => $attributes->has('disabled') ? 'true' : 'false',
    'aria-label'    => ($squared && blank($slot) && blank($label)) ? Str::title($icon ?? $iconAfter ?? 'Button') : null,
    'data-tooltip'  => $hasTooltip ? $tooltip : null,
	'style'         => $hasTooltip ? '--tooltip-delay:' . $tooltipDelay . 'ms' : null,
])" data-slot="button">

    @if ($loadingIndicator)
        <div @class(['absolute inset-0 hidden items-center justify-center']) {{ $loadingAttributes }}>
            <x-ui.icon.loading :size="$iconSize" data-slot="loading-indicator" @class($iconClasses) />
        </div>
    @endif

    @if (filled($icon))
        <x-ui.icon :name="$icon" :variant="$iconVariant" :size="$iconSize" data-slot="btn-icon"
            @class($iconClasses) />
    @endif

    @if ($slot->isNotEmpty())
        <span data-text @class([
            'flex-1 text-left' => filled($badge),
            'hidden ' . $labelHideClass => $responsiveBreakpoint,
            'w-full' => $isDiv,
        ])>{{ $slot }}</span>
    @elseif (filled($label) && $label !== false)
        <span data-text @class([
            'flex-1 text-left' => filled($badge),
            'hidden ' . $labelHideClass => $responsiveBreakpoint,
        ])>{{ $label }}</span>
    @endif

    @if (filled($badge))
        <x-ui.badge :attributes="$badgeAttributes->merge([
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            'size'  => ($size === 'xs' || $size === 'sm') ? 'xs' : 'sm',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            'color' => $color,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ])" class="shrink-0 ml-auto">
            {{ $badge }}
        </x-ui.badge>
    @endif

    @if (filled($iconAfter))
        <x-ui.icon :name="$iconAfter" :variant="$iconVariant" :size="$iconSize" data-slot="btn-icon-after"
            @class($iconClasses) />
    @endif


</x-ui.button.abstract>
