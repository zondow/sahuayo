import * as dom from '../index.js'

export const renderCloseButton = (params) => {
  const closeButton = dom.getCloseButton()

  // Custom class
  dom.applyCustomClass(closeButton, params.customClass, 'closeButton')

  dom.toggle(closeButton, params.showCloseButton)
  closeButton.setAttribute('aria-label', params.closeButtonAriaLabel)
}
