/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/**/*.{jsx,js,html,php}"],
    theme: {
        extend: {
            colors: {
                'custom-purple-primary': '#0C4A6E',
                'custom-purple-secondary': '#3B82F6',
                'custom-black': '#1F2937',
                'custom-gray-purple': '#DBEAFE',
            },
            fontSize: {
                // Paragraph (base text)
                'base': ['1rem', { lineHeight: '1.5', letterSpacing: '0.01em' }], // 16px, suitable for body text
                // Headings
                'h1': ['2.5rem', { lineHeight: '1.2', letterSpacing: '-0.02em' }], // 40px, bold for main headings
                'h2': ['2rem', { lineHeight: '1.3', letterSpacing: '-0.015em' }], // 32px, for subheadings
                'h3': ['1.75rem', { lineHeight: '1.4', letterSpacing: '-0.01em' }], // 28px
                'h4': ['1.5rem', { lineHeight: '1.4', letterSpacing: '0' }], // 24px
                'h5': ['1.25rem', { lineHeight: '1.5', letterSpacing: '0' }], // 20px
                'h6': ['1.125rem', { lineHeight: '1.5', letterSpacing: '0.01em' }], // 18px
                // Custom text sizes
                'custom-sm': ['0.875rem', { lineHeight: '1.6', letterSpacing: '0.02em' }], // 14px, for small text like captions
                'custom-lg': ['1.875rem', { lineHeight: '1.4', letterSpacing: '-0.01em' }], // 30px, for larger body or intro text
            },
        },
    },
    plugins: [],
}