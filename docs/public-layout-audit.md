# Public layout audit

## Extracted in this phase

- `resources/css/public-layout.css` owns styles shared by the public layout,
  navbar, footer, scroll UI, and their existing visual effects.
- `resources/js/public-layout.js` owns the public layout's scroll UI, cursor
  effects, hero/profile effects, and progress bar behavior.
- `resources/js/documentation-notes.js` is loaded only by the public
  documentation view.
- `resources/js/public-faq-accordion.js` is loaded once when an FAQ item
  component is rendered.
- `resources/js/ai-dots-touch.js` remains owned and loaded by the AI dots
  component. Its duplicate global layout load was removed.
- `resources/js/bg_code.js` is no longer loaded globally because no current
  public view renders its `#code-canvas` target.

## Intentionally still inline

- The color-theme bootstrap script stays in the public layout `<head>` because
  it must run before first paint to prevent a light/dark theme flash.
- Hero/profile selectors remain in `public-layout.css` because they were part
  of the layout block and their JavaScript behavior is coupled to the shared
  cursor-effects code. They are candidates for a later home-page extraction.
- Page and component inline styles/scripts remain in place for now. They are
  tightly coupled to their markup and moving them together would increase the
  scope and regression risk of this first extraction.
- The scroll-to-top click handler remains on the layout element to preserve its
  exact current behavior during this phase.

## Suggested next steps

- Audit the large inline blocks in `public/home.blade.php`,
  `components/ai-dots-background.blade.php`, and the service hero partial one
  at a time, with focused browser checks after each extraction.
- Register the home page's `skillsComponent` before Alpine starts. The current
  page logs pre-existing Alpine reference errors because its inline component
  definition appears after the global Alpine bundle.
- Consider splitting `public-layout.css` only when a page-specific ownership
  boundary is clear. Avoid fragmenting shared navbar/footer effects.
- Add browser-level reduced-motion and keyboard interaction checks when an
  existing end-to-end test setup is available.
