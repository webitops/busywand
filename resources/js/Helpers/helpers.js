export function formatPrice(price) {
    const numericPrice = Number(price);
    if (isNaN(numericPrice)) {
        return 'Invalid Price';
    }

    return `$${numericPrice.toFixed(2)}`;
}
