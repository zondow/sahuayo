import * as dom from '../index.js'

export const renderTitle = (params) => {
  const title = dom.getTitle()

  dom.toggle(title, params.title || params.titleText)

  if (params.title) {
    dom.parseHtmlToContainer(params.title, title)
  }

  if (params.titleText) {
    title.innerText = params.titleText
  }

  // Custom class
  dom.applyCustomClass(title, params.customClass, 'title')
}
