import { swalClasses } from '../../classes.js'
import * as dom from '../index.js'
import { renderInput } from './renderInput.js';

export const renderContent = (params) => {
  const content = dom.getContent().querySelector('#' + swalClasses.content)

  // Content as HTML
  if (params.html) {
    dom.parseHtmlToContainer(params.html, content)
    dom.show(content, 'block')

  // Content as plain text
  } else if (params.text) {
    content.textContent = params.text
    dom.show(content, 'block')

  // No content
  } else {
    dom.hide(content)
  }

  renderInput(params)

  // Custom class
  dom.applyCustomClass(dom.getContent(), params.customClass, 'content')
}
