module.exports = {
  theme: {
    colors: {
        'blue-500': '#1B1DC0',

        'white': '#ffffff'
    },
    extend: {}
  },
  variants: {},
  plugins: [
    function({ addUtilities }) {
      const pageBreakUtilities = {
        '.pbb-auto': { 'page-break-before': 'auto', },
        '.pbb-always': { 'page-break-before': 'always', },
        '.pbb-avoid': { 'page-break-before': 'avoid', },
        '.pbb-left': { 'page-break-before': 'left', },
        '.pbb-right': { 'page-break-before': 'right', },
        '.pba-auto': { 'page-break-after': 'auto', },
        '.pba-always': { 'page-break-after': 'always', },
        '.pba-avoid': { 'page-break-after': 'avoid', },
        '.pba-left': { 'page-break-after': 'left', },
        '.pba-right': { 'page-break-after': 'right', },
      }

      addUtilities(pageBreakUtilities);
    }
  ]
}
