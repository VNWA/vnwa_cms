// resources/js/fontAwesome.js

import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { library } from '@fortawesome/fontawesome-svg-core'

library.add(fas)
library.add(fab)

export const fasArray = Object.keys(library.definitions.fas)
export const fabArray = Object.keys(library.definitions.fab)
