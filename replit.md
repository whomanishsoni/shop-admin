# Overview

This is a **Laravel 12 web application** that serves as a full-stack PHP framework project. The application uses Laravel's MVC architecture with integrated image processing capabilities through Intervention Image, DataTables for dynamic table rendering, and a modern frontend stack built with Vite and Tailwind CSS 4. The project includes an admin panel interface using the SB Admin 2 template.

# User Preferences

Preferred communication style: Simple, everyday language.

# System Architecture

## Backend Framework
- **Laravel 12**: Modern PHP framework handling routing, middleware, authentication, and business logic
- **PHP 8.2+**: Minimum version requirement for modern language features and type safety
- **Composer**: Dependency management for PHP packages

## Frontend Architecture
- **Vite 7**: Modern build tool for asset compilation and hot module replacement
- **Tailwind CSS 4**: Utility-first CSS framework with custom theme configuration
- **Axios**: HTTP client for AJAX requests with CSRF token handling
- **SB Admin 2**: Bootstrap-based admin template for backend UI

## Image Processing
- **Intervention Image 3.11**: Primary image manipulation library supporting both GD and Imagick drivers
- Handles image resizing, watermarking, format conversion, and thumbnail generation
- Supports animated GIF processing through dedicated decoder/encoder

## Data Presentation
- **Yajra DataTables 12.5**: Server-side processing for large datasets
- Provides sorting, filtering, and pagination capabilities
- Oracle database compatibility layer

## Development Tools
- **Laravel Pail**: Command-line log viewer for debugging
- **Laravel Pint**: Opinionated code formatter based on PHP-CS-Fixer
- **Laravel Sail**: Docker-based local development environment
- **Laravel Tinker**: REPL for interactive debugging

## Testing Framework
- **PHPUnit 11.5**: Unit and feature testing
- **Faker**: Test data generation
- **Mockery**: Mocking library for isolated unit tests

# External Dependencies

## Core Laravel Services
- **Laravel Prompts**: CLI user input handling
- **Laravel Serializable Closure**: Closure serialization for queues and events
- **Monolog**: Logging abstraction layer
- **Carbon**: Date/time manipulation library

## HTTP & API
- **Guzzle HTTP Client 7**: HTTP requests to external APIs
- **PSR-7/PSR-18**: HTTP message interfaces for interoperability
- **CORS Middleware**: Cross-origin resource sharing configuration

## Utilities
- **Nesbot Carbon**: Advanced date/time handling
- **Ramsey UUID**: UUID generation
- **Doctrine Inflector**: String singularization/pluralization
- **Symfony Components**: Console, HTTP Foundation, Error Handler, Finder

## Asset Management
- **Tailwind CSS Vite Plugin**: Integration between Tailwind and Vite
- **Concurrently**: Run multiple npm scripts simultaneously

## Error Handling
- **Whoops**: Pretty error pages for development
- **Symfony Error Handler**: Production error handling