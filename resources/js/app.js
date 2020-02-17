import hljs from 'highlight.js/lib/highlight'
import javascript from 'highlight.js/lib/languages/javascript'

require('./bootstrap')

hljs.registerLanguage('javascript', javascript)

hljs.initHighlightingOnLoad()

