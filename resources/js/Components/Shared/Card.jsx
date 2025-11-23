export default function Card({ children, className = '', hover = false, ...props }) {
    const baseClasses = 'bg-white rounded-2xl shadow-lg overflow-hidden border border-primary/10';
    const hoverClasses = hover ? 'transition-all duration-300 hover:shadow-2xl hover:border-primary/30 hover:-translate-y-1 cursor-pointer' : '';

    return (
        <div className={`${baseClasses} ${hoverClasses} ${className}`} {...props}>
            {children}
        </div>
    );
}
