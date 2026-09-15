(function () {
  'use strict';

  function text(selector, value) {
    var el = document.querySelector(selector);
    if (el) {
      el.textContent = value || '';
    }
  }

  function formatDate(value) {
    if (!value) return '';
    var parts = value.split('-');
    if (parts.length !== 3) return value;
    return Number(parts[0]) + '年' + Number(parts[1]) + '月' + Number(parts[2]) + '日';
  }

  function formatDateInputValue(date) {
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var day = String(date.getDate()).padStart(2, '0');
    return year + '-' + month + '-' + day;
  }

  function setupDefaultDeliveryDate(form) {
    var dateField = form.querySelector('[name="date"]');
    if (!dateField) {
      return;
    }

    var tomorrow = new Date();
    tomorrow.setHours(12, 0, 0, 0);
    tomorrow.setDate(tomorrow.getDate() + 1);

    var tomorrowValue = formatDateInputValue(tomorrow);
    dateField.min = tomorrowValue;

    if (!dateField.value) {
      dateField.value = tomorrowValue;
    }
  }

  function setupOrderConfirmation(form) {
    var inputArea = form.querySelector('#cf7-input-area');
    var confirmArea = form.querySelector('#cf7-confirm-area');

    if (!inputArea || !confirmArea) {
      return;
    }

    setupDefaultDeliveryDate(form);
    confirmArea.hidden = true;

    form.addEventListener('submit', function (event) {
      if (form.dataset.taguchiFinalSubmit === '1') {
        delete form.dataset.taguchiFinalSubmit;
        return;
      }

      event.preventDefault();
      event.stopImmediatePropagation();

      if (!form.reportValidity()) {
        return;
      }

      var site = form.querySelector('[name="site_select"]');
      var siteAddress = form.querySelector('[name="site_address"]');
      var date = form.querySelector('[name="date"]');
      var time = form.querySelector('[name="time"]');
      var message = form.querySelector('[name="message"]');

      var selectedSite = site && site.options && site.selectedIndex >= 0
        ? site.options[site.selectedIndex].text
        : '';

      text('#cf7-confirm-area .confirm-site dl:nth-child(1) dd', selectedSite);
      text('#cf7-confirm-area .confirm-site dl:nth-child(2) dd', siteAddress ? siteAddress.value : '');
      text('#cf7-confirm-area .confirm-site dl:nth-child(3) dd', formatDate(date ? date.value : ''));
      text('#cf7-confirm-area .confirm-site dl:nth-child(4) dd', time ? time.value : '');
      text('#cf7-confirm-area .confirm-message .message-content', message ? message.value : '');

      var legacyInfo = confirmArea.querySelector('.confirm-info');
      if (legacyInfo) {
        legacyInfo.hidden = true;
      }

      var requestDate = confirmArea.querySelector('.request-date');
      if (requestDate) {
        requestDate.textContent = 'ご依頼日 ' + new Intl.DateTimeFormat('ja-JP').format(new Date());
      }

      inputArea.hidden = true;
      confirmArea.hidden = false;
      confirmArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, true);

    document.addEventListener('click', function (event) {
      var target = event.target;
      if (!(target instanceof Element)) {
        return;
      }

      var backButton = target.closest('#back-button');
      if (backButton && form.contains(backButton)) {
        event.preventDefault();
        event.stopPropagation();
        confirmArea.hidden = true;
        inputArea.hidden = false;
        inputArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
        return;
      }

      var realSubmitButton = target.closest('#real-submit-button');
      if (realSubmitButton && form.contains(realSubmitButton)) {
        event.preventDefault();
        event.stopPropagation();
        form.dataset.taguchiFinalSubmit = '1';

        if (typeof form.requestSubmit === 'function') {
          form.requestSubmit();
        } else {
          form.submit();
        }
      }
    }, true);

    document.addEventListener('wpcf7invalid', function () {
      confirmArea.hidden = true;
      inputArea.hidden = false;
    });

    document.addEventListener('wpcf7mailfailed', function () {
      confirmArea.hidden = true;
      inputArea.hidden = false;
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('.order-form .wpcf7-form');
    if (form) {
      setupOrderConfirmation(form);
    }
  });
})();
