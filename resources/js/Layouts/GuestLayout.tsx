import { PropsWithChildren } from 'react';

// Guest layout is now a passthrough — Login and Register handle their own full-screen layout
export default function Guest({ children }: PropsWithChildren) {
    return <>{children}</>;
}
