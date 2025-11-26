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

### Routing Architecture

The application uses an **Inertia.js monolith** architecture (as per ADR-001 in technical spec):

- **Inertia.js Routes** (`routes/web.php`): All page rendering and navigation
  - Returns React components via Inertia responses
  - Handles page-to-page navigation and data operations
  - Routes: Top page (`/`), Suggestion creation (`POST /suggestions`), Suggestion results (`/suggestions/{uuid}`), Detail page (`/suggestions/detail/{uuid}`)
- **API Routes** (`routes/api.php`): Currently unused (reserved for future microservice integration)

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
- `SuggestionSet`: User suggestion requests (linked to ModelPlans via pivot table)
- `Catchphrase`: AI-generated marketing copy (linked to ModelPlan)
- `AiModel`: AI model management (performance priority, daily limits)
- `UserProfile`, `UserActionLog`, `UserSpotInterest`: User data and behavior

### Database & Geographic Features

- **PostGIS Extension**: Enabled for spatial queries (distance calculations, geographic searches)
- **Laravel Magellan Package**: (`clickbar/laravel-magellan`) Provides PostGIS integration and spatial query helpers
- Geographic coordinates stored as `latitude`/`longitude` pairs
- Spatial indexes on location columns for performance

### Frontend Structure

- Entry point: `resources/js/app.jsx`
- Pages: `resources/js/Pages/` (Inertia.js components)
  - `Top/Index.jsx`: Landing page with departure location input
  - `Suggestion/Show.jsx`: Suggestion waiting/results page
  - `Suggestion/Detail.jsx`: Individual suggestion detail page
- Components: `resources/js/Components/`
- Vite handles module bundling and HMR

## Documentation

Primary documentation is in the `documents/` directory:

- **`1_proposal.md`**: Business proposal (Japanese)
  - Product vision and value proposition
  - Market analysis and business model
  - Product/UX design and roadmap
  - High-level technical overview (detailed specs in 2_technical_spec.md)

- **`2_technical_spec.md`**: Technical specifications (Japanese)
  - Ubiquitous language (terminology)
  - System architecture (C4 Model diagrams)
  - Architecture Decision Records (ADRs)
  - Database design (ER diagrams, table definitions, ENUM types)

- **`documents/references/`**: Reference materials
  - `temp.md`: Frequently used for feeding large context to Claude
  - `spots_example.md`: Examples of spot types

The proposal emphasizes **"Deep Personalization"** as the core differentiator, using AI to understand latent user preferences and present travel options in the most appealing way for each individual.

### Documentation Operation Policy for Claude

**`documents/1_proposal.md`**:
- **Default**: Read-only
- **Exception**: Auto-edit when business perspective changes are expected, such as:
  - WHY (Why are we building this service?)
  - WHAT (What are we providing?)
  - HOW (How to realize it - business perspective)

**`documents/2_technical_spec.md`**:
- **Default**: Read-only
- **Exception**: Auto-edit when technical implementation policy changes are expected, such as:
  - HOW (How to realize it - technical perspective)
  - System design details
  - Implementation guidelines

**`documents/references/`**:
- **Default**: No editing, no reading required
- **Exception**: Read when explicitly instructed
- **Exception**: Edit only when special instructions are given

## Development Principles for This Project

### MVP Focus

Currently in MVP phase prioritizing **development speed** over premature optimization:
- Monolith architecture chosen over microservices
- Feature completeness prioritized over scalability concerns
- Database design supports future scaling but implements pragmatic solutions now

### AI Integration

AI-powered suggestion generation uses a **two-phase architecture** for optimal user experience:

#### Phase 1: Asynchronous AI Analysis (Background Processing)

AI analysis runs continuously in the background, preparing data in advance:

- **`DispatchAsyncAnalysisTasksJob`**: Task dispatcher that selects and dispatches analysis jobs
  - **A-type tasks (80%)**: Spot-related analysis
    1. Spot detail analysis (`AnalyzeSpotDetailJob`)
    2. Spot priority determination (`AnalyzeSpotPriorityJob`)
    3. Spot listing (`AnalyzeSpotListingJob`)
  - **B-type tasks (20%)**: Plan-related analysis
    1. Image selection (`AnalyzeImageSelectionJob`)
    2. Main spot selection (`AnalyzeMainSpotJob`)
    3. Model plan generation (`AnalyzeModelPlanJob`)
    4. Catchphrase generation (`AnalyzeCatchphraseJob`)

- **AI Model Management** (`app/Models/AiModel.php`):
  - Dynamic model selection based on performance priority
  - Daily API limit management
  - Progressive quality improvement (higher-performance models overwrite lower-performance results)

- **Task Selection** (`app/Services/AI/TaskSelector.php`):
  - Probabilistic task type selection (80% A-type, 20% B-type)
  - Priority-based task ordering within each type
  - Concurrent task limit enforcement

- **Lock Management** (`app/Services/AI/LockManager.php`):
  - Optimistic locking to prevent duplicate analysis
  - Timeout-based lock release
  - Support for Cluster, Spot, and ModelPlan models

#### Phase 2: Real-time Suggestion Generation (User Request)

When users request suggestions, the system uses pre-analyzed data:

- **`GenerateSuggestionsJob`** (`app/Jobs/GenerateSuggestionsJob.php`): Simplified pipeline
  1. Cluster selection (probabilistic weighting from pre-analyzed clusters)
  2. Model plan selection (from pre-generated plans)
  3. Travel time calculation
  4. Result composition via `suggestion_set_model_plans` pivot table

This architecture reduces user wait time from 3-5 minutes to under 1 minute while maintaining high-quality AI-generated content.

#### Supporting Infrastructure

- **Configuration** (`config/ai.php`):
  - Toggle async analysis on/off
  - Task selection parameters (probabilities, concurrent limits)
  - Model selection parameters (interval margins, execution history)
  - Cache TTL for each task type

- **Prompts** (`storage/prompts/`):
  - `spot_listing.txt`, `spot_priority_analysis.txt`, `spot_detail_analysis.txt`
  - `catchphrase_generation.txt`, `model_plan_generation.txt`
  - `main_spot_selection.txt`, `image_selection.txt`

- **Performance Tracking**: Catchphrases tracked with `performance_score` for A/B testing
- **User Behavior Logging**: `user_action_logs` table prepared for future ML model training

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
