# Portfolio Roadmap

This document tracks intentionally deferred product improvements.

It is not a general task dump. Each item should explain its purpose, expected
scope, and completion criteria so it remains useful when implementation starts.

## Planned

### Public project detail pages

**Status:** Deferred

**Purpose:** Give every public project its own shareable case-study page instead
of presenting projects only as cards in the portfolio catalogue.

**Expected route:**

```text
/proyectos/{slug}
```

**Expected scope:**

- Add a stable, unique slug to projects.
- Create a public route and controller action that only exposes projects with
  public visibility.
- Create an individual Blade view for each project.
- Show the project's problem, solution, technical decisions, technologies,
  images, results, and public links when that information is available.
- Link project cards to their corresponding detail page.
- Provide project-specific title, description, canonical URL, Open Graph data,
  social image, and structured data.
- Include public project URLs in the sitemap.

**Completion criteria:**

- Every public project has a working canonical URL.
- Draft, internal, deleted, or otherwise private projects cannot be accessed
  through the public detail route.
- Project cards link to the detail page without removing access to public demo
  and repository links.
- Each detail page has useful project-specific SEO and social-sharing metadata.
- Feature tests cover public access, private-project protection, and unknown
  slugs.

**Deferred because:** The current catalogue is sufficient for the immediate
portfolio needs. This should be implemented when there is enough case-study
content to make the individual pages meaningfully different from the cards.

## Completed

Move items here after implementation, including the completion date and a short
reference to the relevant change.
