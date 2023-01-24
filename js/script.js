document.querySelectorAll('input[type= "number"]').forEach((inputNumber) => {
  inputNumber.oninput = () => {
    if (inputNumber.ariaValueMax.length > inputNumber.maxLength)
      inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
  };
});
