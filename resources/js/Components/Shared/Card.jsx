export default function Card({ children, className = '', hover = false, ...props }) {
    const baseClasses = 'bg-white rounded-lg shadow-md overflow-hidden';
    const hoverClasses = hover ? 'transition-shadow hover:shadow-lg cursor-pointer' : '';

    return (
        <div className={`${baseClasses} ${hoverClasses} ${className}`} {...props}>
            {children}
        </div>
    );
}
