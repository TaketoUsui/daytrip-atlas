# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Daytrip Atlas (日帰り地図帳)** is a web service that provides AI-powered personalized day trip recommendations. Users input their departure location and select tags, then receive multiple curated travel plans. The service aims to eliminate "search fatigue" and decision-making burden by transforming the user experience from "searching" to "choosing" and "discovering."

## Technology Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: React 19 + Inertia.js 2
- **Database**: PostgreSQL 16 + PostGIS 3.4
- **Testing**: Pest 4
- **CSS**: Tailwind CSS 4
- **Development**: Docker Compose with separate containers for nginx, php-fpm, PostgreSQL, queue worker, and Node.js

## Development Environment

### Initial Setup

```bash
# Start Docker containers and initialize environment
./scripts/init.sh

# Access development server at http://localhost:${APP_PORT}
# Vite dev server runs at http://localhost:5173
```

### Common Commands

**Backend (run inside php container):**
```bash
# Enter PHP container
docker-compose exec php bash

# Run migrations
docker-compose exec php php artisan migrate

# Generate IDE helper (improves autocomplete)
docker-compose exec php php artisan ide-helper:generate

# Clear caches
docker-compose exec php php artisan config:clear
docker-compose exec php php artisan cache:clear

# Tinker (REPL)
docker-compose exec php php artisan tinker
```

**Frontend:**
```bash
# Start Vite dev server (already running in node container)
docker-compose exec node npm run dev

# Build for production
docker-compose exec node npm run build
```

**Queue Management:**
```bash
# Queue worker runs automatically in docker-compose (queue service)
# To manually run queue worker:
docker-compose exec php php artisan queue:work --sleep=3 --tries=3

# Monitor queue
docker-compose exec php php artisan queue:listen --tries=1
```

**Testing:**
```bash
# Run all tests (uses Pest)
docker-compose exec php php artisan test

# Run specific test file
docker-compose exec php php artisan test tests/Feature/ExampleTest.php

# Run with coverage (if configured)
docker-compose exec php php artisan test --coverage
```

**Development Workflow:**
The project provides a comprehensive dev command that runs multiple services concurrently:
```bash
# This runs: server, queue worker, pail (logs), and vite dev
composer dev
```

**Code Quality:**
```bash
# Run Laravel Pint (code formatter)
docker-compose exec php ./vendor/bin/pint

# Watch logs
docker-compose exec php php artisan pail --timeout=0
```

## Architecture

### Hybrid Routing Approach

The application uses a **"modern monolith"** architecture with two routing strategies:

1. **Inertia.js Routes** (`routes/web.php`): For page rendering and navigation
   - Returns React components via Inertia responses
   - Handles traditional page-to-page navigation
   - Example: Cluster detail pages, Top page

2. **API Routes** (`routes/api.php`): For asynchronous data operations without page transitions
   - RESTful endpoints under `/api/*`
   - Used for non-blocking data fetching and updates
   - Example: Polling suggestion generation status

### Asynchronous Processing

Heavy operations (like AI-powered suggestion generation) use **Laravel Queue Jobs**:
- Jobs stored in `app/Jobs/`
- Default queue connection: `database` (see `config/queue.php`)
- Queue worker runs as a dedicated Docker service (`queue` in compose.yml)
- Critical for user experience during AI generation tasks

### Data Architecture: Spot-Centric Approach

The database design centers around **"Spots"** as the fundamental unit of information:

- **Spots** (`spots` table): Core entity representing locations/attractions
- **Clusters** (`clusters` table): Geographic groupings of spots for day trips
- **Model Plans** (`model_plans` table): Curated itineraries for clusters
- **Model Plan Items** (`model_plan_items` table): Individual spots within plans with ordering and duration

This design enables:
- High reusability of spot data
- Flexible plan composition
- Geographic queries using PostGIS

### Personalization Foundation

The system separates user preferences from AI-generated content:

- **User Preferences**: Stored in `user_profiles.preferences` (JSONB)
- **AI-Generated Catchphrases**: Separate `catchphrases` table with performance metrics
- **User Interactions**: Tracked in `user_action_logs` for future ML training
- **Suggestion Sets**: Complete user request context stored in `suggestion_sets` table

### JSONB Schema Management

**Important**: All JSONB columns use `spatie/laravel-data` for type-safe schema management:

**Data Classes** (`app/Data/`):
- `UserPreferencesData`: Schema for `user_profiles.preferences`
- `ProcessingDetailsData`: Schema for `suggestion_sets.processing_details`
- `InputTagsData`: Schema for `suggestion_sets.input_tags_json`
- `SourceAnalysisData`: Schema for `catchphrases.source_analysis`

**Usage Pattern**:
```php
// Creating with Data objects
$suggestionSet->update([
    'processing_details' => new ProcessingDetailsData(
        found_clusters: ['Cluster A', 'Cluster B']
    )
]);

// Accessing typed properties
$clusters = $suggestionSet->processing_details->found_clusters; // string[]
```

**Benefits**:
- Type safety and IDE autocomplete
- Validation at the Data class level
- Consistent schema across the application
- Easy migration when schema evolves

Models using this pattern:
- `UserProfile` (with `WithData` trait)
- `SuggestionSet` (with `WithData` trait)
- `Catchphrase` (with `WithData` trait)

### Key Models

Located in `app/Models/`:
- `Spot`: Individual locations/attractions
- `Cluster`: Geographic groupings of spots
- `ModelPlan` & `ModelPlanItem`: Itinerary management
- `SuggestionSet` & `SuggestionSetItem`: User suggestion requests and results
- `Catchphrase`: AI-generated marketing copy
- `UserProfile`, `UserActionLog`, `UserSpotInterest`: User data and behavior

### Database & Geographic Features

- **PostGIS Extension**: Enabled for spatial queries (distance calculations, geographic searches)
- **Laravel Magellan Package**: (`clickbar/laravel-magellan`) Provides PostGIS integration and spatial query helpers
- Geographic coordinates stored as `latitude`/`longitude` pairs
- Spatial indexes on location columns for performance

### Frontend Structure

- Entry point: `resources/js/app.jsx`
- Pages: `resources/js/Pages/` (Inertia.js components)
  - `TopPage.jsx`: Landing/search page
  - `Cluster/`: Cluster detail views
  - `Suggestion/`: Suggestion generation and results
- Components: `resources/js/Components/`
- Vite handles module bundling and HMR

## Documentation

Primary documentation is in the `documents/` directory:

- `1_proposal.md`: Product vision, market analysis, business model (Japanese)
- `2_DB_DesignDocument.md`: Database schema, ER diagrams, design philosophy (Japanese)
- `mvp/`: MVP-specific planning documents

The proposal emphasizes **"Deep Personalization"** as the core differentiator, using AI to understand latent user preferences and present travel options in the most appealing way for each individual.

### MVP Development Documentation

**Key documents for MVP development:**

- **`mvp/10_DevelopmentPlan.md`**: Comprehensive MVP development strategy
  - 6-phase development approach (Phase 1: Foundation → Phase 6: PostGIS Integration)
  - Technical stack details
  - Development principles and coding standards
  - Git strategy and commit conventions
  - Performance targets and security policies

- **`mvp/11_ProgressTracking.md`**: Detailed progress tracking and task management
  - Phase-by-phase progress summary with completion percentages
  - Detailed task lists with status indicators (✅ Done, 🔄 In Progress, ❌ Not Started, ⚠️ Needs Review)
  - Current priority tasks and effort estimates
  - Issues and blockers tracking
  - Regular updates on completion of each phase or major milestone

**Progress Management Policy:**

All MVP development work should be tracked using documents 10 and 11:
- **Before starting tasks**: Check `11_ProgressTracking.md` for current priorities and task status
- **During development**: Update task status in `11_ProgressTracking.md` as work progresses
- **After completing tasks**: Mark tasks as completed (✅) and update progress percentages
- **When plans change**: Update `10_DevelopmentPlan.md` to reflect new strategies or approaches
- **When issues arise**: Add to the "Issues & Blockers" section in `11_ProgressTracking.md`

These documents serve as the single source of truth for MVP development status and should be kept up-to-date throughout the development process.

## Development Principles for This Project

### MVP Focus

Currently in MVP phase prioritizing **development speed** over premature optimization:
- Monolith architecture chosen over microservices
- Feature completeness prioritized over scalability concerns
- Database design supports future scaling but implements pragmatic solutions now

### AI Integration

While AI features are core to the vision, current implementation may be foundational:
- `GenerateSuggestionsJob` exists but may be a placeholder (`app/Jobs/GenerateSuggestionsJob.php`)
- AI-generated catchphrases tracked separately for A/B testing
- User interaction logs prepared for future ML model training

### Testing

- Framework: **Pest 4** (not PHPUnit directly)
- Test environment uses SQLite in-memory database
- Tests located in `tests/Feature/` and `tests/Unit/`
- Run via `php artisan test` (configured in `composer.json`)

## Important Notes

- **Container-based Development**: All commands should run inside Docker containers
- **Port Configuration**: App port configurable via `.env` (`APP_PORT`), Vite on 5173
- **Queue Worker**: Must be running for async job processing (auto-starts with docker-compose)
- **PostGIS**: Database extensions must be enabled for geographic features
- **HMR Configuration**: Vite configured for Docker with host `0.0.0.0` and HMR host `localhost`
- **Japanese Language**: Documentation and comments are primarily in Japanese

## Git Workflow Policy

**IMPORTANT: Claude Code should NEVER execute `git commit` commands.**

- All git commits are performed manually by the developer
- Claude Code may:
  - Run `git status` to check current state
  - Run `git diff` to review changes
  - Run `git log` to check history
  - Suggest commit messages if requested
- Claude Code must NOT:
  - Execute `git add` commands
  - Execute `git commit` commands
  - Execute `git push` commands
  - Create commits automatically

When implementation work is complete, Claude Code should:
1. Inform the user that changes are ready
2. Show a summary of modified files (via `git status`)
3. Wait for the user to manually commit the changes
